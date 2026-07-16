<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with('user');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('sale_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%");
            });
        }

        $sales = $query->latest()->paginate(10)->withQueryString();

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::where('status', 'active')->where('stock_qty', '>', 0)->orderBy('name')->get();

        return view('sales.create', compact('products'));
    }

    public function store(Request $request, StockService $stockService)
    {
        $data = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'payment_method' => 'required|in:cash,card,bank_transfer',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($data, $stockService) {
                $subtotal = 0;
                $sale = Sale::create([
                    'sale_number' => $stockService->nextNumber('SALE'),
                    'customer_name' => $data['customer_name'] ?? null,
                    'customer_phone' => $data['customer_phone'] ?? null,
                    'payment_method' => $data['payment_method'],
                    'discount' => $data['discount'] ?? 0,
                    'tax' => $data['tax'] ?? 0,
                    'status' => 'completed',
                    'user_id' => auth()->id(),
                ]);

                foreach ($data['items'] as $item) {
                    $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                    if ($product->stock_qty < $item['quantity']) {
                        throw new \RuntimeException("Not enough stock for {$product->name}");
                    }

                    $lineSubtotal = $product->sale_price * $item['quantity'];
                    $subtotal += $lineSubtotal;

                    $sale->items()->create([
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'quantity' => $item['quantity'],
                        'unit_price' => $product->sale_price,
                        'subtotal' => $lineSubtotal,
                    ]);

                    $stockService->adjust(
                        $product,
                        -1 * (int) $item['quantity'],
                        'sale',
                        $sale->sale_number,
                        'POS sale'
                    );
                }

                $total = $subtotal - ($data['discount'] ?? 0) + ($data['tax'] ?? 0);

                $sale->update([
                    'subtotal' => $subtotal,
                    'total' => max($total, 0),
                ]);
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('sales.index')
            ->with('success', 'Sale completed successfully.');
    }

    public function show(Sale $sale)
    {
        $sale->load(['user', 'items.product']);

        return view('sales.show', compact('sale'));
    }

    public function void(Sale $sale, StockService $stockService)
    {
        if ($sale->status === 'voided') {
            return back()->with('error', 'This sale has already been voided.');
        }

        try {
            DB::transaction(function () use ($sale, $stockService) {
                foreach ($sale->items as $item) {
                    $product = Product::lockForUpdate()->findOrFail($item->product_id);

                    $stockService->adjust(
                        $product,
                        (int) $item->quantity,
                        'return',
                        $sale->sale_number,
                        'Sale voided — stock restored'
                    );
                }

                $sale->update(['status' => 'voided']);
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Sale voided and stock restored.');
    }
}
