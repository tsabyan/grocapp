# Grocery Admin Dashboard

A Laravel + Inertia.js + Vue 3 admin dashboard application for managing grocery store operations.

## Features

- Admin authentication with role-based access control
- Category management (CRUD)
- Product management (CRUD) with images, pricing, and stock tracking
- Inventory management with stock movement tracking
- Order management with status updates
- Minimalist black & white UI design

## Requirements

- PHP 8.2+
- Composer
- Node.js and npm
- SQLite (default) or MySQL

## Installation

1. Clone the repository and install dependencies:

```bash
composer install
npm install
```

2. Set up environment:

```bash
cp .env.example .env
php artisan key:generate
```

3. Configure database (SQLite - default):

In your `.env` file, set:
```
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

Make sure the SQLite database file exists:
```bash
touch database/database.sqlite
```

4. Run migrations and seeders:

```bash
php artisan migrate --seed
```

This will create:
- Admin user: `admin@example.com` / `password` (is_admin = true)
- Regular user: `test@example.com` / `password`
- Sample categories, products, and orders

5. Start the development server:

```bash
php artisan serve
npm run dev
```

Visit `http://localhost:8000` and log in with the admin credentials to access the admin dashboard at `/admin/dashboard`.

## Database

### SQLite (Current)

The application is configured to use SQLite by default. The database file is located at `database/database.sqlite`.

### MySQL (Future)

The database schema is designed to be compatible with both SQLite and MySQL. To switch to MySQL:

1. Update your `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

2. Create the MySQL database:
```bash
mysql -u root -p
CREATE DATABASE your_database_name;
```

3. Run migrations:
```bash
php artisan migrate --seed
```

**Note:** All migrations use Laravel's schema builder which works on both SQLite and MySQL. Status fields use strings (not enum types) for compatibility, and price fields use `decimal(10,2)` which works on both database systems.

## Admin Routes

All admin routes are prefixed with `/admin` and require authentication and admin role:

- `/admin/dashboard` - Dashboard with statistics
- `/admin/categories` - Category management
- `/admin/products` - Product management
- `/admin/inventory` - Inventory and stock management
- `/admin/orders` - Order management

## Commands

- `php artisan migrate` - Run database migrations
- `php artisan migrate --seed` - Run migrations and seed database
- `php artisan serve` - Start Laravel development server
- `npm run dev` - Start Vite development server
- `npm run build` - Build assets for production

## Tech Stack

- **Backend:** Laravel 12
- **Frontend:** Vue 3 (Composition API, `<script setup>`)
- **Build Tool:** Vite
- **Styling:** Tailwind CSS
- **UI Framework:** Reka UI components
- **Authentication:** Laravel Fortify
- **Database:** SQLite (default), MySQL compatible

## License

MIT
