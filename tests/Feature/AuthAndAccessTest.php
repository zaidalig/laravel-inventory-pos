<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthAndAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/')->assertRedirect('/login');
    }

    public function test_owner_can_view_dashboard(): void
    {
        $user = User::create([
            'name' => 'Owner',
            'email' => 'owner@test.local',
            'password' => 'password',
            'role' => 'owner',
            'status' => 'active',
        ]);

        $this->actingAs($user)->get('/')->assertOk();
    }

    public function test_owner_can_manage_inventory(): void
    {
        $user = User::create([
            'name' => 'Owner',
            'email' => 'owner-inv@test.local',
            'password' => 'password',
            'role' => 'owner',
            'status' => 'active',
        ]);

        $this->actingAs($user)->get('/products')->assertOk();
        $this->actingAs($user)->get('/users')->assertOk();
    }

    public function test_cashier_can_access_sales_but_not_inventory(): void
    {
        $user = User::create([
            'name' => 'Cashier',
            'email' => 'cashier@test.local',
            'password' => 'password',
            'role' => 'cashier',
            'status' => 'active',
        ]);

        $this->actingAs($user)->get('/sales')->assertOk();
        $this->actingAs($user)->get('/products')->assertForbidden();
    }

    public function test_viewer_cannot_manage_sales(): void
    {
        $user = User::create([
            'name' => 'Viewer',
            'email' => 'viewer@test.local',
            'password' => 'password',
            'role' => 'viewer',
            'status' => 'active',
        ]);

        $this->actingAs($user)->get('/sales')->assertForbidden();
    }
}
