<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Services\MediaStorage;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'supplier']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->boolean('low_stock')) {
            $query->whereColumn('stock_qty', '<=', 'reorder_level');
        }

        [$sort, $direction] = $this->tableSort($request, ['created_at', 'name', 'sku', 'stock_qty', 'sale_price']);
        $products = $query->orderBy($sort, $direction)->paginate($this->tablePerPage($request))->withQueryString();
        $categories = Category::where('status', 'active')->orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('status', 'active')->orderBy('name')->get();
        $suppliers = Supplier::where('status', 'active')->orderBy('name')->get();

        return view('products.create', compact('categories', 'suppliers'));
    }

    public function store(ProductRequest $request)
    {
        $data = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            $data['image_path'] = MediaStorage::store($request->file('image'), 'product-images');
        }

        $product = Product::create($data);

        return redirect()->route('products.index')
            ->with('success', "Product \"{$product->name}\" created.");
    }

    public function show(Product $product)
    {
        $product->load(['category', 'supplier', 'stockMovements' => fn ($q) => $q->latest()->limit(15)]);

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::where('status', 'active')->orderBy('name')->get();
        $suppliers = Supplier::where('status', 'active')->orderBy('name')->get();

        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                MediaStorage::delete($product->image_path);
            }
            $data['image_path'] = MediaStorage::store($request->file('image'), 'product-images');
        }

        $product->update($data);

        return redirect()->route('products.show', $product)
            ->with('success', "Product \"{$product->name}\" updated.");
    }

    public function destroy(Product $product)
    {
        $name = $product->name;

        if ($product->image_path) {
            MediaStorage::delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', "Product \"{$name}\" deleted.");
    }
}
