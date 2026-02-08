# Role-Based Access Control (RBAC) Documentation

This document describes the role-based access implementation for the Car Selling Platform.

## User Roles

| Role   | Description                                      |
|--------|--------------------------------------------------|
| Admin  | Full access: manage users, all listings, delete any car |
| Seller | Create, edit, delete own car listings; view watchlist   |
| Buyer  | Browse cars, save to watchlist, contact sellers        |

## Role Selection on Signup

New users choose their role during registration:
- **Browse & Buy** → `buyer`
- **Sell Cars** → `seller`

Admins are typically created via seeders or database updates.

## Navigation by Role

### Admin
- Admin Dashboard
- All Listings (manage all cars)
- Browse Cars
- Sell Car (create listings)
- My Listings (in dropdown)
- Watchlist

### Seller
- Browse Cars
- My Listings
- Create Listing
- Sell Car (primary CTA)
- My Listings (dropdown)
- Watchlist

### Buyer
- Browse Cars
- Watchlist
- Watchlist (dropdown)
- No "Sell Car" or "My Listings"

## Dashboards

- **Admin Dashboard** (`/admin/dashboard`): Statistics (total cars, users), recent listings, recent users.
- **Seller Dashboard** (`/dashboard` for sellers): My listings count, published/drafts, create listing CTA.
- **Buyer Dashboard** (`/dashboard` for buyers): Watchlist count, browse cars CTA.

Admins visiting `/dashboard` are redirected to `/admin/dashboard`.

## Route Protection

### Seller-Only Routes (middleware: `seller`)
- `GET /cars/create` – Create listing form
- `POST /cars` – Store new listing
- `GET /cars/{car}/edit` – Edit form
- `PUT /cars/{car}` – Update listing
- `DELETE /cars/{car}` – Delete listing

Both Sellers and Admins pass the `seller` middleware (`canManageListings()`).

### Admin-Only Routes (middleware: `admin`)
- `GET /admin/dashboard`
- `GET /admin/cars`
- `DELETE /admin/cars/{car}`

## Car Policy

`App\Policies\CarPolicy`:
- **update**: Car owner OR admin
- **delete**: Car owner OR admin

Used with `@can('update', $car)` and `@can('delete', $car)` in Blade.

## Key Files

| File | Purpose |
|------|---------|
| `app/Models/User.php` | `hasRole()`, `canManageListings()`, role constants |
| `app/Policies/CarPolicy.php` | Car update/delete authorization |
| `app/Http/Middleware/EnsureUserIsSeller.php` | Restricts listing management to sellers/admins |
| `app/Http/Middleware/EnsureUserIsAdmin.php` | Restricts admin routes |
| `resources/views/Layouts/app.blade.php` | Role-based navigation |
| `resources/views/dashboard/seller.blade.php` | Seller dashboard |
| `resources/views/dashboard/buyer.blade.php` | Buyer dashboard |
| `resources/views/car/show.blade.php` | Edit/Delete (policy), Watchlist toggle |

## Blade Usage

```blade
@if(Auth::user()->hasRole('admin'))
    {{-- Admin-only content --}}
@endif

@if(Auth::user()->hasRole('seller'))
    {{-- Seller-only content --}}
@endif

@if(Auth::user()->hasRole('buyer'))
    {{-- Buyer-only content --}}
@endif

@if(Auth::user()->canManageListings())
    {{-- Seller or Admin content --}}
@endif

@can('update', $car)
    <a href="{{ route('cars.edit', $car) }}">Edit</a>
@endcan

@can('delete', $car)
    <form action="{{ route('cars.destroy', $car) }}" method="POST">
        @csrf
        @method('DELETE')
        <button>Delete</button>
    </form>
@endcan
```

## Migration

Run migrations to ensure the `role` column exists and legacy `user` roles are converted to `buyer`:

```bash
php artisan migrate
```

Migration: `2026_02_07_000000_update_users_role_for_admin_seller_buyer.php`

## Watchlist Toggle

Authenticated users can add/remove cars from their watchlist on the car show page. Route: `POST /cars/{car}/watchlist` (name: `cars.watchlist.toggle`).
