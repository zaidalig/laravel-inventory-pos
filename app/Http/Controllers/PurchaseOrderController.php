<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = PurchaseOrder::with(['supplier', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('order_number', 'like', "%{$search}%");
        }

        [$sort, $direction] = $this->tableSort($request, ['created_at', 'order_number', 'status', 'total_amount']);
        $orders = $query->orderBy($sort, $direction)->paginate($this->tablePerPage($request))->withQueryString();

        return view('purchases.index', compact('orders'));
    }

    public function create()
    {
        $suppliers = Supplier::where('status', 'active')->orderBy('name')->get();
        $products = Product::where('status', 'active')->orderBy('name')->get();

        return view('purchases.create', compact('suppliers', 'products'));
    }

    public function store(Request $request, StockService $stockService)
    {
        $data = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_cost' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($data, $stockService) {
            $total = 0;
            $order = PurchaseOrder::create([
                'order_number' => $stockService->nextNumber('PO'),
                'supplier_id' => $data['supplier_id'],
                'order_date' => $data['order_date'],
                'status' => 'received',
                'notes' => $data['notes'] ?? null,
                'user_id' => auth()->id(),
            ]);

            foreach ($data['items'] as $item) {
                $subtotal = $item['quantity'] * $item['unit_cost'];
                $total += $subtotal;

                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_cost' => $item['unit_cost'],
                    'subtotal' => $subtotal,
                ]);

                $product = Product::find($item['product_id']);
                $stockService->adjust(
                    $product,
                    (int) $item['quantity'],
                    'purchase',
                    $order->order_number,
                    'Purchase order received'
                );
            }

            $order->update(['total_amount' => $total]);
        });

        return redirect()->route('purchases.index')
            ->with('success', 'Purchase order created and stock updated.');
    }

    public function show(PurchaseOrder $purchase)
    {
        $purchase->load(['supplier', 'user', 'items.product']);

        return view('purchases.show', compact('purchase'));
    }
}
