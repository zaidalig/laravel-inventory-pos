<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SaleReturnTest extends TestCase
{
    use RefreshDatabase;

    protected function makeCompletedSale(): Sale
    {
        $category = Category::create(['name' => 'General', 'status' => 'active']);

        $product = Product::create([
            'category_id' => $category->id,
            'sku' => 'SKU-001',
            'name' => 'Widget',
            'cost_price' => 5,
            'sale_price' => 10,
            'stock_qty' => 8,
            'status' => 'active',
        ]);

        $sale = Sale::create([
            'sale_number' => 'SALE-00001',
            'subtotal' => 20,
            'discount' => 0,
            'tax' => 0,
            'total' => 20,
            'payment_method' => 'cash',
            'status' => 'completed',
        ]);

        SaleItem::create([
            'sale_id' => $sale->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => 2,
            'unit_price' => 10,
            'subtotal' => 20,
        ]);

        $product->decrement('stock_qty', 2);

        return $sale;
    }

    public function test_manager_can_void_sale_and_restore_stock(): void
    {
        $user = User::create([
            'name' => 'Manager',
            'email' => 'mgr-void@test.local',
            'password' => 'password',
            'role' => 'manager',
            'status' => 'active',
        ]);

        $sale = $this->makeCompletedSale();
        $product = Product::first();

        $this->actingAs($user)
            ->patch("/sales/{$sale->id}/void")
            ->assertRedirect();

        $this->assertSame('voided', $sale->fresh()->status);
        $this->assertSame(8, $product->fresh()->stock_qty);
    }

    public function test_cashier_cannot_void_sale(): void
    {
        $user = User::create([
            'name' => 'Cashier',
            'email' => 'cash-void@test.local',
            'password' => 'password',
            'role' => 'cashier',
            'status' => 'active',
        ]);

        $sale = $this->makeCompletedSale();

        $this->actingAs($user)
            ->patch("/sales/{$sale->id}/void")
            ->assertForbidden();

        $this->assertSame('completed', $sale->fresh()->status);
    }
}
