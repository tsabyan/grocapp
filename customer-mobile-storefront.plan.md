# Customer Mobile Storefront Implementation

## Overview

Replace `/` and `/dashboard` routes with a mobile-first customer storefront. Create customer controllers, pages, and implement cart/checkout functionality using Laravel session storage.

## Database Changes

1. **Add user_id to orders table**

- Create migration: `add_user_id_to_orders_table.php`
- Add nullable `user_id` foreign key to `orders` table
- Update `Order` model to include `user_id` in fillable and add `user()` relationship

## Backend Controllers

Create `App\Http\Controllers\Customer` namespace with:

1. **HomeController** (`index()`)

- Load categories and featured products (latest/active)
- Return `Customer/Home` Inertia page

2. **CategoryController** (`show($slug)`)

- Find category by slug
- Load paginated products in category (active only)
- Return `Customer/CategoryProducts` page

3. **ProductController** (`show($slug)`)

- Find product by slug (active only)
- Return `Customer/ProductDetail` page

4. **CartController**

- `index()` - Return `Customer/Cart` page with session cart data
- `add(Request $request)` - Add product to session cart
- `update(Request $request)` - Update cart item quantity
- `remove(Request $request)` - Remove item from cart
- Cart stored in Laravel session as array: `[product_id => quantity]`

5. **CheckoutController**

- `index()` - Show checkout form (redirect if cart empty)
- `store(Request $request)` - Validate, create Order + OrderItems, clear cart, redirect to success

6. **DashboardController** (`index()`)

- Redirect admins to `/admin/dashboard`
- Load user's orders (where `user_id` matches)
- Return `Customer/Dashboard` page

7. **OrderController** (`show($id)`)

- Show order detail page for authenticated user's orders

## Routes

Update `routes/web.php`:

- Replace `/` route → `HomeController@index`
- Replace `/dashboard` route → `DashboardController@index` (auth middleware)
- Add `/categories/{slug}` → `CategoryController@show`
- Add `/products/{slug}` → `ProductController@show`
- Add `/cart` → `CartController@index`
- Add `/cart/add`, `/cart/update`, `/cart/remove` → CartController methods
- Add `/checkout` → `CheckoutController@index` (auth middleware)
- Add `/checkout` POST → `CheckoutController@store` (auth middleware)
- Add `/orders/{order}/success` → `OrderController@show` (auth middleware)

## Frontend Pages

Create `resources/js/Pages/Customer/` directory:

1. **CustomerLayout.vue**

- Mobile-first layout with top bar (app name, cart icon with count)
- Sticky bottom cart button (optional)
- Uses Tailwind neutral colors (white, black, gray)

2. **Home.vue**

- Hero section with title/subtitle
- Search bar (can be placeholder for now)
- Horizontal scrolling categories list
- Featured products grid/list
- Links to CategoryProducts and ProductDetail

3. **CategoryProducts.vue**

- Category name header
- Product grid/list (mobile-friendly)
- Each product shows: name, price, unit, thumbnail, "Add to Cart" button

4. **ProductDetail.vue**

- Product image, name, price, unit, description
- Stock status display
- Quantity selector (min 1)
- "Add to Cart" button
- Single-column mobile layout

5. **Cart.vue**

- List cart items with product details
- Quantity +/- controls
- Unit price and subtotal per item
- Total items count and total price
- "Proceed to Checkout" button

6. **Checkout.vue**

- Mobile form: customer_name, customer_phone, delivery_address (textarea), payment_method (select)
- Form validation
- Submit creates order via POST to `/checkout`

7. **OrderSuccess.vue** (or Order/Show.vue)

- Thank you message
- Order summary (items, total, status)
- Mobile layout

8. **Dashboard.vue**

- Profile summary (name, email)
- List of user's orders (ID, date, status, total)
- Links to order detail pages

## Implementation Details

- **Cart Storage**: Laravel session (`session()->put('cart', [...])`)
- **Product Filtering**: Only show `is_active = true` products
- **Stock Management**: Optionally reduce stock on checkout (can be added later)
- **Order Status**: Default to 'pending' on creation
- **Mobile Design**: All pages optimized for 360-430px width, single-column layouts
- **Styling**: Tailwind CSS only, neutral palette (white, black, gray)

## Files to Create/Modify

**New Files:**

- `database/migrations/YYYY_MM_DD_add_user_id_to_orders_table.php`
- `app/Http/Controllers/Customer/HomeController.php`
- `app/Http/Controllers/Customer/CategoryController.php`
- `app/Http/Controllers/Customer/ProductController.php`
- `app/Http/Controllers/Customer/CartController.php`
- `app/Http/Controllers/Customer/CheckoutController.php`
- `app/Http/Controllers/Customer/DashboardController.php`
- `app/Http/Controllers/Customer/OrderController.php`
- `resources/js/Pages/Customer/CustomerLayout.vue`
- `resources/js/Pages/Customer/Home.vue`
- `resources/js/Pages/Customer/CategoryProducts.vue`
- `resources/js/Pages/Customer/ProductDetail.vue`
- `resources/js/Pages/Customer/Cart.vue`
- `resources/js/Pages/Customer/Checkout.vue`
- `resources/js/Pages/Customer/Dashboard.vue`
- `resources/js/Pages/Customer/Order/Show.vue` (or OrderSuccess.vue)

**Modified Files:**

- `routes/web.php` - Replace default routes, add customer routes
- `app/Models/Order.php` - Add user_id to fillable, add user() relationship

### To-dos

- [ ] Create migration to add user_id to orders table and update Order model
- [ ] Create all Customer controllers (Home, Category, Product, Cart, Checkout, Dashboard, Order)
- [ ] Update routes/web.php to replace default routes and add customer routes
- [ ] Create CustomerLayout.vue with mobile-first design and cart icon
- [ ] Create Customer/Home.vue with categories and featured products
- [ ] Create Customer/CategoryProducts.vue for category product listings
- [ ] Create Customer/ProductDetail.vue with add to cart functionality
- [ ] Create Customer/Cart.vue with cart management (add/update/remove)
- [ ] Create Customer/Checkout.vue form and order creation logic
- [ ] Create Customer/Order/Show.vue for order confirmation page
- [ ] Create Customer/Dashboard.vue with user orders list
