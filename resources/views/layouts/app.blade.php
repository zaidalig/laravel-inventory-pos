<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Store Inventory POS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset_cdn('fontawesome', 'vendor/fontawesome/css/all.min.css') }}">
    <link href="{{ asset_cdn('bootstrap_css', 'vendor/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <i class="fa-solid fa-store"></i>
            <span>Store POS</span>
        </div>
        <ul class="nav-list">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i><span>Dashboard</span>
                </a>
            </li>
            @can('manage-sales')
            <li class="nav-item">
                <a href="{{ route('sales.index') }}" class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-cash-register"></i><span>Sales / POS</span>
                </a>
            </li>
            @endcan
            @can('manage-inventory')
            <li class="nav-item">
                <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-boxes-stacked"></i><span>Products</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-tags"></i><span>Categories</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('suppliers.index') }}" class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-truck-field"></i><span>Suppliers</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('purchases.index') }}" class="nav-link {{ request()->routeIs('purchases.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-cart-flatbed"></i><span>Purchases</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('stock.index') }}" class="nav-link {{ request()->routeIs('stock.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-arrows-rotate"></i><span>Stock</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('reports.sales') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-csv"></i><span>Reports</span>
                </a>
            </li>
            @endcan
            @can('manage-users')
            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-gear"></i><span>Users</span>
                </a>
            </li>
            @endcan
            @can('manage-users')
                <li class="nav-item">
                <a href="{{ route('activity.index') }}" class="nav-link {{ request()->routeIs('activity.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-clock-rotate-left"></i><span>Activity Logs</span>
                </a>
            </li>
            @endcan
        </ul>
    </aside>

    <div class="main-wrapper">
        <header class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light d-lg-none" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button>
                <h4 class="mb-0 fw-bold">@yield('page_title', 'Dashboard')</h4>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-primary-subtle text-primary border px-3 py-2 rounded-pill">{{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill"><i class="fa-solid fa-right-from-bracket me-1"></i>Logout</button>
                </form>
            </div>
        </header>

        <main class="content-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show"><i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show"><i class="fa-solid fa-circle-exclamation me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @yield('content')
        </main>
        <footer class="app-footer"><i class="fa-solid fa-store me-2"></i>Store Inventory &amp; POS</footer>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0"><h5 class="modal-title fw-bold">Confirm Delete</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body"><p class="mb-0">Delete <strong id="deleteItemName"></strong>?</p></div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST">@csrf @method('DELETE')<button type="submit" class="btn btn-danger">Delete</button></form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset_cdn('bootstrap_js', 'vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', () => document.getElementById('sidebar').classList.toggle('active'));
        const deleteModal = document.getElementById('deleteModal');
        deleteModal?.addEventListener('show.bs.modal', e => {
            const btn = e.relatedTarget;
            document.getElementById('deleteItemName').textContent = btn.getAttribute('data-name');
            document.getElementById('deleteForm').action = btn.getAttribute('data-url');
        });
    </script>
    @yield('scripts')
</body>
</html>
