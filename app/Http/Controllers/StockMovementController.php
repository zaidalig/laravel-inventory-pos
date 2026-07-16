<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use App\Services\StockService;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index(Request $request)
    {
        $query = StockMovement::with(['product', 'user']);

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->input('product_id'));
        }

        $movements = $query->latest()->paginate(15)->withQueryString();
        $products = Product::orderBy('name')->get();

        return view('stock.index', compact('movements', 'products'));
    }

    public function create()
    {
        $products = Product::where('status', 'active')->orderBy('name')->get();

        return view('stock.create', compact('products'));
    }

    public function store(Request $request, StockService $stockService)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:purchase,adjustment,return',
            'quantity' => 'required|integer|not_in:0',
            'notes' => 'nullable|string|max:500',
        ]);

        $product = Product::findOrFail($data['product_id']);
        $qty = abs((int) $data['quantity']);

        if (in_array($data['type'], ['adjustment'], true) && (int) $data['quantity'] < 0) {
            $qty = (int) $data['quantity'];
        } elseif ($data['type'] === 'adjustment') {
            $qty = (int) $data['quantity'];
        } else {
            $qty = abs((int) $data['quantity']);
        }

        try {
            $stockService->adjust($product, $qty, $data['type'], null, $data['notes'] ?? null);
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('stock.index')
            ->with('success', 'Stock movement recorded.');
    }
}
