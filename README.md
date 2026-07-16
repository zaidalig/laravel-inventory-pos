# laravel-mysql-inventory-pos

Laravel MySQL store inventory and point-of-sale system with products, categories, suppliers, purchase orders, stock movements, sales/POS, users, roles, dashboard, and activity logs.

Built as a portfolio app using Laravel MVC, Blade, Bootstrap 5, MySQL, migrations, seeders, and Form Requests.

## Tech Stack

- PHP 8.2+
- Laravel 11
- MySQL / MariaDB
- Blade + Bootstrap 5 + Font Awesome

## Features

- Dashboard with product count, low stock alerts, sales today, suppliers, and pending POs
- Product CRUD with SKU, cost/sale price, stock qty, reorder level, category and supplier links
- Category and supplier management
- Purchase orders that receive stock and log movements
- POS sales with multi-line items, discount, tax, and automatic stock deduction
- Manual stock adjustments (purchase, return, adjustment)
- Stock movement ledger
- Role-based access: owner, manager, cashier, viewer
- User management and activity logs

## Database Tables

- `users` (role, status)
- `categories`
- `suppliers`
- `products`
- `purchase_orders`, `purchase_order_items`
- `sales`, `sale_items`
- `stock_movements`
- `activity_logs`

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Create MySQL database:

```sql
CREATE DATABASE inventory_pos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Set `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_pos
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations and seed:

```bash
php artisan migrate --seed
php artisan serve
```

Open: `http://127.0.0.1:8000`

## Demo Login

| Email | Role | Password |
|-------|------|----------|
| owner@example.com | Owner | password |
| manager@example.com | Manager | password |
| cashier@example.com | Cashier | password |

## Useful Commands

```bash
php artisan migrate:fresh --seed
php artisan route:list
```
