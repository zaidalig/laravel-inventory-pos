<?php

namespace Tests\Feature;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalesReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_download_sales_csv(): void
    {
        $owner = User::create([
            'name' => 'Owner',
            'email' => 'owner-report@test.local',
            'password' => 'password',
            'role' => 'owner',
            'status' => 'active',
        ]);

        Sale::create([
            'sale_number' => 'SALE-001',
            'customer_name' => 'Alice',
            'subtotal' => 100,
            'discount' => 0,
            'tax' => 0,
            'total' => 100,
            'payment_method' => 'cash',
            'status' => 'completed',
            'user_id' => $owner->id,
        ]);

        $from = now()->toDateString();
        $to = now()->toDateString();

        $response = $this->actingAs($owner)->get('/reports/sales?from='.$from.'&to='.$to.'&export=1');

        $response->assertOk();
        $response->assertHeader('content-disposition', 'attachment; filename=sales-'.$from.'-'.$to.'.csv');
        $this->assertStringContainsString('Sale #', $response->streamedContent());
        $this->assertStringContainsString('SALE-001', $response->streamedContent());
        $this->assertStringContainsString('Alice', $response->streamedContent());
    }

    public function test_cashier_cannot_access_sales_report(): void
    {
        $cashier = User::create([
            'name' => 'Cashier',
            'email' => 'cashier-report@test.local',
            'password' => 'password',
            'role' => 'cashier',
            'status' => 'active',
        ]);

        $this->actingAs($cashier)->get('/reports/sales')->assertForbidden();
        $this->actingAs($cashier)->get('/reports/sales?export=1')->assertForbidden();
    }
}
