<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\Sale;
use App\Models\Supplier;
class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'low_stock' => Product::whereColumn('stock_qty', '<=', 'reorder_level')->count(),
            'suppliers' => Supplier::where('status', 'active')->count(),
            'sales_today' => Sale::whereDate('created_at', today())->sum('total'),
            'purchases_pending' => PurchaseOrder::where('status', 'pending')->count(),
        ];

        $lowStockProducts = Product::with('category')
            ->whereColumn('stock_qty', '<=', 'reorder_level')
            ->orderBy('stock_qty')
            ->limit(5)
            ->get();

        $recentSales = Sale::with('user')->latest()->limit(5)->get();
        $recentLogs = ActivityLog::with('user')->latest()->limit(8)->get();

        return view('dashboard', compact('stats', 'lowStockProducts', 'recentSales', 'recentLogs'));
    }
}
