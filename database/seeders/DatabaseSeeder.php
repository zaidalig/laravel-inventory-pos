<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Store Owner', 'email' => 'owner@example.com', 'password' => 'password', 'role' => 'owner', 'status' => 'active'],
            ['name' => 'Store Manager', 'email' => 'manager@example.com', 'password' => 'password', 'role' => 'manager', 'status' => 'active'],
            ['name' => 'POS Cashier', 'email' => 'cashier@example.com', 'password' => 'password', 'role' => 'cashier', 'status' => 'active'],
            ['name' => 'Read Only', 'email' => 'viewer@example.com', 'password' => 'password', 'role' => 'viewer', 'status' => 'inactive'],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $categories = [
            ['name' => 'Electronics', 'description' => 'Gadgets and accessories'],
            ['name' => 'Groceries', 'description' => 'Daily food items'],
            ['name' => 'Clothing', 'description' => 'Apparel and wearables'],
        ];

        foreach ($categories as $category) {
            Category::create($category + ['status' => 'active']);
        }

        $suppliers = [
            ['name' => 'Tech Wholesale Co', 'email' => 'sales@techwholesale.test', 'phone' => '+1 555 0101'],
            ['name' => 'Fresh Foods Ltd', 'email' => 'orders@freshfoods.test', 'phone' => '+1 555 0102'],
            ['name' => 'Urban Apparel', 'email' => 'hello@urbanapparel.test', 'phone' => '+1 555 0103'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier + ['status' => 'active', 'address' => '123 Market Street']);
        }

        $products = [
            ['sku' => 'EL-001', 'name' => 'Wireless Mouse', 'category_id' => 1, 'supplier_id' => 1, 'cost_price' => 8.50, 'sale_price' => 14.99, 'stock_qty' => 45, 'reorder_level' => 10, 'unit' => 'pcs'],
            ['sku' => 'EL-002', 'name' => 'USB-C Cable', 'category_id' => 1, 'supplier_id' => 1, 'cost_price' => 3.20, 'sale_price' => 7.99, 'stock_qty' => 120, 'reorder_level' => 20, 'unit' => 'pcs'],
            ['sku' => 'GR-001', 'name' => 'Organic Rice 5kg', 'category_id' => 2, 'supplier_id' => 2, 'cost_price' => 6.00, 'sale_price' => 9.50, 'stock_qty' => 30, 'reorder_level' => 8, 'unit' => 'bag'],
            ['sku' => 'GR-002', 'name' => 'Olive Oil 1L', 'category_id' => 2, 'supplier_id' => 2, 'cost_price' => 5.50, 'sale_price' => 8.99, 'stock_qty' => 4, 'reorder_level' => 10, 'unit' => 'bottle'],
            ['sku' => 'CL-001', 'name' => 'Cotton T-Shirt', 'category_id' => 3, 'supplier_id' => 3, 'cost_price' => 7.00, 'sale_price' => 15.99, 'stock_qty' => 60, 'reorder_level' => 15, 'unit' => 'pcs'],
            ['sku' => 'CL-002', 'name' => 'Denim Jeans', 'category_id' => 3, 'supplier_id' => 3, 'cost_price' => 18.00, 'sale_price' => 34.99, 'stock_qty' => 25, 'reorder_level' => 8, 'unit' => 'pcs'],
        ];

        foreach ($products as $product) {
            Product::create($product + ['status' => 'active']);
        }
    }
}
