<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Gate::define('manage-users', fn ($user) => $user->canManageUsers());
        Gate::define('manage-inventory', fn ($user) => $user->canManageInventory());
        Gate::define('manage-sales', fn ($user) => $user->canManageSales());
        Gate::define('void-sales', fn ($user) => $user->canVoidSales());
    }
}
