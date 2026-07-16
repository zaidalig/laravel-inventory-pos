<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Store Inventory POS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <main class="auth-page">
        <div class="auth-panel shadow-sm">
            <div class="mb-4">
                <div class="brand-mark mb-3"><i class="fa-solid fa-store"></i></div>
                <h1 class="h3 fw-bold mb-1">Store POS Login</h1>
                <p class="text-muted mb-0">Inventory, purchases, and point of sale.</p>
            </div>
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
            <form action="{{ route('login.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', 'owner@example.com') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control" required>
                    <div class="form-text">Demo: <strong>password</strong></div>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-semibold">Login</button>
            </form>
        </div>
    </main>
</body>
</html>
