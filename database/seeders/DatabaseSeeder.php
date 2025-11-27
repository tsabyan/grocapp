<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // Create regular users
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'John Customer',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);

        // Create categories
        $fruits = Category::create([
            'name' => 'Fruits',
            'slug' => 'fruits',
            'description' => 'Fresh fruits and produce',
        ]);

        $vegetables = Category::create([
            'name' => 'Vegetables',
            'slug' => 'vegetables',
            'description' => 'Fresh vegetables',
        ]);

        $dairy = Category::create([
            'name' => 'Dairy',
            'slug' => 'dairy',
            'description' => 'Dairy products and eggs',
        ]);

        $beverages = Category::create([
            'name' => 'Beverages',
            'slug' => 'beverages',
            'description' => 'Drinks and beverages',
        ]);

        $meat = Category::create([
            'name' => 'Meat & Seafood',
            'slug' => 'meat-seafood',
            'description' => 'Fresh meat and seafood',
        ]);

        $bakery = Category::create([
            'name' => 'Bakery',
            'slug' => 'bakery',
            'description' => 'Fresh baked goods',
        ]);

        $snacks = Category::create([
            'name' => 'Snacks',
            'slug' => 'snacks',
            'description' => 'Snacks and chips',
        ]);

        $frozen = Category::create([
            'name' => 'Frozen Foods',
            'slug' => 'frozen-foods',
            'description' => 'Frozen products',
        ]);

        // Create products - Fruits
        $apple = Product::create([
            'category_id' => $fruits->id,
            'name' => 'Red Apples',
            'slug' => 'red-apples',
            'description' => 'Fresh red apples, sweet and crisp',
            'price' => 2.99,
            'unit' => 'kg',
            'stock' => 50,
            'is_active' => true,
        ]);

        $banana = Product::create([
            'category_id' => $fruits->id,
            'name' => 'Bananas',
            'slug' => 'bananas',
            'description' => 'Fresh yellow bananas',
            'price' => 1.99,
            'unit' => 'kg',
            'stock' => 75,
            'is_active' => true,
        ]);

        $orange = Product::create([
            'category_id' => $fruits->id,
            'name' => 'Oranges',
            'slug' => 'oranges',
            'description' => 'Fresh sweet oranges',
            'price' => 3.49,
            'unit' => 'kg',
            'stock' => 40,
            'is_active' => true,
        ]);

        $strawberry = Product::create([
            'category_id' => $fruits->id,
            'name' => 'Strawberries',
            'slug' => 'strawberries',
            'description' => 'Fresh red strawberries',
            'price' => 4.99,
            'unit' => 'pack',
            'stock' => 25,
            'is_active' => true,
        ]);

        $grapes = Product::create([
            'category_id' => $fruits->id,
            'name' => 'Grapes',
            'slug' => 'grapes',
            'description' => 'Fresh green grapes',
            'price' => 5.99,
            'unit' => 'kg',
            'stock' => 30,
            'is_active' => true,
        ]);

        // Create products - Vegetables
        $carrot = Product::create([
            'category_id' => $vegetables->id,
            'name' => 'Carrots',
            'slug' => 'carrots',
            'description' => 'Fresh orange carrots',
            'price' => 1.49,
            'unit' => 'kg',
            'stock' => 60,
            'is_active' => true,
        ]);

        $tomato = Product::create([
            'category_id' => $vegetables->id,
            'name' => 'Tomatoes',
            'slug' => 'tomatoes',
            'description' => 'Fresh red tomatoes',
            'price' => 2.49,
            'unit' => 'kg',
            'stock' => 45,
            'is_active' => true,
        ]);

        $onion = Product::create([
            'category_id' => $vegetables->id,
            'name' => 'Onions',
            'slug' => 'onions',
            'description' => 'Fresh yellow onions',
            'price' => 1.99,
            'unit' => 'kg',
            'stock' => 55,
            'is_active' => true,
        ]);

        $potato = Product::create([
            'category_id' => $vegetables->id,
            'name' => 'Potatoes',
            'slug' => 'potatoes',
            'description' => 'Fresh white potatoes',
            'price' => 1.79,
            'unit' => 'kg',
            'stock' => 70,
            'is_active' => true,
        ]);

        $lettuce = Product::create([
            'category_id' => $vegetables->id,
            'name' => 'Lettuce',
            'slug' => 'lettuce',
            'description' => 'Fresh green lettuce',
            'price' => 2.99,
            'unit' => 'head',
            'stock' => 35,
            'is_active' => true,
        ]);

        // Create products - Dairy
        $milk = Product::create([
            'category_id' => $dairy->id,
            'name' => 'Whole Milk',
            'slug' => 'whole-milk',
            'description' => 'Fresh whole milk, 1 liter',
            'price' => 3.49,
            'unit' => 'liter',
            'stock' => 40,
            'is_active' => true,
        ]);

        $cheese = Product::create([
            'category_id' => $dairy->id,
            'name' => 'Cheddar Cheese',
            'slug' => 'cheddar-cheese',
            'description' => 'Sharp cheddar cheese, 250g',
            'price' => 4.99,
            'unit' => 'pack',
            'stock' => 30,
            'is_active' => true,
        ]);

        $yogurt = Product::create([
            'category_id' => $dairy->id,
            'name' => 'Greek Yogurt',
            'slug' => 'greek-yogurt',
            'description' => 'Creamy Greek yogurt, 500g',
            'price' => 3.99,
            'unit' => 'pack',
            'stock' => 25,
            'is_active' => true,
        ]);

        $butter = Product::create([
            'category_id' => $dairy->id,
            'name' => 'Butter',
            'slug' => 'butter',
            'description' => 'Salted butter, 250g',
            'price' => 2.99,
            'unit' => 'pack',
            'stock' => 50,
            'is_active' => true,
        ]);

        $eggs = Product::create([
            'category_id' => $dairy->id,
            'name' => 'Eggs',
            'slug' => 'eggs',
            'description' => 'Fresh chicken eggs, 12 pieces',
            'price' => 3.49,
            'unit' => 'dozen',
            'stock' => 60,
            'is_active' => true,
        ]);

        // Create products - Beverages
        $water = Product::create([
            'category_id' => $beverages->id,
            'name' => 'Bottled Water',
            'slug' => 'bottled-water',
            'description' => 'Pure drinking water, 500ml',
            'price' => 0.99,
            'unit' => 'bottle',
            'stock' => 100,
            'is_active' => true,
        ]);

        $juice = Product::create([
            'category_id' => $beverages->id,
            'name' => 'Orange Juice',
            'slug' => 'orange-juice',
            'description' => 'Fresh orange juice, 1 liter',
            'price' => 2.99,
            'unit' => 'bottle',
            'stock' => 40,
            'is_active' => true,
        ]);

        $soda = Product::create([
            'category_id' => $beverages->id,
            'name' => 'Cola',
            'slug' => 'cola',
            'description' => 'Carbonated cola drink, 2 liters',
            'price' => 2.49,
            'unit' => 'bottle',
            'stock' => 50,
            'is_active' => true,
        ]);

        // Create products - Meat & Seafood
        $chicken = Product::create([
            'category_id' => $meat->id,
            'name' => 'Chicken Breast',
            'slug' => 'chicken-breast',
            'description' => 'Fresh chicken breast, boneless',
            'price' => 8.99,
            'unit' => 'kg',
            'stock' => 20,
            'is_active' => true,
        ]);

        $beef = Product::create([
            'category_id' => $meat->id,
            'name' => 'Ground Beef',
            'slug' => 'ground-beef',
            'description' => 'Fresh ground beef, 80/20',
            'price' => 9.99,
            'unit' => 'kg',
            'stock' => 15,
            'is_active' => true,
        ]);

        $salmon = Product::create([
            'category_id' => $meat->id,
            'name' => 'Salmon Fillet',
            'slug' => 'salmon-fillet',
            'description' => 'Fresh salmon fillet',
            'price' => 15.99,
            'unit' => 'kg',
            'stock' => 10,
            'is_active' => true,
        ]);

        // Create products - Bakery
        $bread = Product::create([
            'category_id' => $bakery->id,
            'name' => 'White Bread',
            'slug' => 'white-bread',
            'description' => 'Fresh white bread loaf',
            'price' => 2.49,
            'unit' => 'loaf',
            'stock' => 30,
            'is_active' => true,
        ]);

        $croissant = Product::create([
            'category_id' => $bakery->id,
            'name' => 'Croissants',
            'slug' => 'croissants',
            'description' => 'Fresh butter croissants, 4 pieces',
            'price' => 3.99,
            'unit' => 'pack',
            'stock' => 25,
            'is_active' => true,
        ]);

        // Create products - Snacks
        $chips = Product::create([
            'category_id' => $snacks->id,
            'name' => 'Potato Chips',
            'slug' => 'potato-chips',
            'description' => 'Crispy potato chips, 200g',
            'price' => 2.99,
            'unit' => 'bag',
            'stock' => 80,
            'is_active' => true,
        ]);

        $cookies = Product::create([
            'category_id' => $snacks->id,
            'name' => 'Chocolate Cookies',
            'slug' => 'chocolate-cookies',
            'description' => 'Chocolate chip cookies, 300g',
            'price' => 3.49,
            'unit' => 'pack',
            'stock' => 45,
            'is_active' => true,
        ]);

        // Create products - Frozen
        $iceCream = Product::create([
            'category_id' => $frozen->id,
            'name' => 'Vanilla Ice Cream',
            'slug' => 'vanilla-ice-cream',
            'description' => 'Creamy vanilla ice cream, 1 liter',
            'price' => 4.99,
            'unit' => 'tub',
            'stock' => 35,
            'is_active' => true,
        ]);

        $frozenPizza = Product::create([
            'category_id' => $frozen->id,
            'name' => 'Frozen Pizza',
            'slug' => 'frozen-pizza',
            'description' => 'Margherita frozen pizza',
            'price' => 5.99,
            'unit' => 'piece',
            'stock' => 20,
            'is_active' => true,
        ]);

        // Create stock movements for some products
        StockMovement::create([
            'product_id' => $apple->id,
            'change' => 50,
            'reason' => 'Initial stock',
            'created_at' => now()->subDays(10),
        ]);

        StockMovement::create([
            'product_id' => $banana->id,
            'change' => 75,
            'reason' => 'Initial stock',
            'created_at' => now()->subDays(10),
        ]);

        StockMovement::create([
            'product_id' => $apple->id,
            'change' => -5,
            'reason' => 'Sold to customer',
            'created_at' => now()->subDays(5),
        ]);

        StockMovement::create([
            'product_id' => $milk->id,
            'change' => 40,
            'reason' => 'New delivery',
            'created_at' => now()->subDays(3),
        ]);

        StockMovement::create([
            'product_id' => $milk->id,
            'change' => -10,
            'reason' => 'Sold to customer',
            'created_at' => now()->subDays(1),
        ]);

        StockMovement::create([
            'product_id' => $chicken->id,
            'change' => 20,
            'reason' => 'Fresh delivery',
            'created_at' => now()->subDays(2),
        ]);

        StockMovement::create([
            'product_id' => $chicken->id,
            'change' => -5,
            'reason' => 'Sold to customer',
            'created_at' => now()->subHours(6),
        ]);

        // Create orders with different statuses
        $order1 = Order::create([
            'customer_name' => 'John Doe',
            'customer_phone' => '+1234567890',
            'delivery_address' => '123 Main St, City, State 12345',
            'status' => 'pending',
            'total_price' => 8.97,
            'created_at' => now()->subDays(2),
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $apple->id,
            'quantity' => 2,
            'unit_price' => 2.99,
            'subtotal' => 5.98,
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $banana->id,
            'quantity' => 1,
            'unit_price' => 1.99,
            'subtotal' => 1.99,
        ]);

        $order2 = Order::create([
            'customer_name' => 'Jane Smith',
            'customer_phone' => '+0987654321',
            'delivery_address' => '456 Oak Ave, City, State 67890',
            'status' => 'confirmed',
            'total_price' => 15.47,
            'created_at' => now()->subDays(1),
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $milk->id,
            'quantity' => 2,
            'unit_price' => 3.49,
            'subtotal' => 6.98,
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $bread->id,
            'quantity' => 2,
            'unit_price' => 2.49,
            'subtotal' => 4.98,
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $eggs->id,
            'quantity' => 1,
            'unit_price' => 3.49,
            'subtotal' => 3.49,
        ]);

        $order3 = Order::create([
            'customer_name' => 'Bob Johnson',
            'customer_phone' => '+1122334455',
            'delivery_address' => '789 Pine Rd, City, State 54321',
            'status' => 'delivered',
            'total_price' => 4.48,
            'created_at' => now()->subDays(5),
        ]);

        OrderItem::create([
            'order_id' => $order3->id,
            'product_id' => $carrot->id,
            'quantity' => 2,
            'unit_price' => 1.49,
            'subtotal' => 2.98,
        ]);

        OrderItem::create([
            'order_id' => $order3->id,
            'product_id' => $water->id,
            'quantity' => 1,
            'unit_price' => 0.99,
            'subtotal' => 0.99,
        ]);

        $order4 = Order::create([
            'customer_name' => 'Alice Williams',
            'customer_phone' => '+2233445566',
            'delivery_address' => '321 Elm St, City, State 98765',
            'status' => 'delivered',
            'total_price' => 28.97,
            'created_at' => now()->subDays(7),
        ]);

        OrderItem::create([
            'order_id' => $order4->id,
            'product_id' => $chicken->id,
            'quantity' => 1,
            'unit_price' => 8.99,
            'subtotal' => 8.99,
        ]);

        OrderItem::create([
            'order_id' => $order4->id,
            'product_id' => $tomato->id,
            'quantity' => 2,
            'unit_price' => 2.49,
            'subtotal' => 4.98,
        ]);

        OrderItem::create([
            'order_id' => $order4->id,
            'product_id' => $onion->id,
            'quantity' => 1,
            'unit_price' => 1.99,
            'subtotal' => 1.99,
        ]);

        OrderItem::create([
            'order_id' => $order4->id,
            'product_id' => $lettuce->id,
            'quantity' => 2,
            'unit_price' => 2.99,
            'subtotal' => 5.98,
        ]);

        OrderItem::create([
            'order_id' => $order4->id,
            'product_id' => $cheese->id,
            'quantity' => 1,
            'unit_price' => 4.99,
            'subtotal' => 4.99,
        ]);

        OrderItem::create([
            'order_id' => $order4->id,
            'product_id' => $bread->id,
            'quantity' => 1,
            'unit_price' => 2.49,
            'subtotal' => 2.49,
        ]);

        $order5 = Order::create([
            'customer_name' => 'Charlie Brown',
            'customer_phone' => '+3344556677',
            'delivery_address' => '654 Maple Dr, City, State 11111',
            'status' => 'cancelled',
            'total_price' => 12.47,
            'created_at' => now()->subDays(3),
        ]);

        OrderItem::create([
            'order_id' => $order5->id,
            'product_id' => $salmon->id,
            'quantity' => 0.5,
            'unit_price' => 15.99,
            'subtotal' => 7.99,
        ]);

        OrderItem::create([
            'order_id' => $order5->id,
            'product_id' => $orange->id,
            'quantity' => 1,
            'unit_price' => 3.49,
            'subtotal' => 3.49,
        ]);

        OrderItem::create([
            'order_id' => $order5->id,
            'product_id' => $water->id,
            'quantity' => 1,
            'unit_price' => 0.99,
            'subtotal' => 0.99,
        ]);

        $order6 = Order::create([
            'customer_name' => 'Diana Prince',
            'customer_phone' => '+4455667788',
            'delivery_address' => '987 Cedar Ln, City, State 22222',
            'status' => 'confirmed',
            'total_price' => 18.95,
            'created_at' => now()->subHours(12),
        ]);

        OrderItem::create([
            'order_id' => $order6->id,
            'product_id' => $strawberry->id,
            'quantity' => 2,
            'unit_price' => 4.99,
            'subtotal' => 9.98,
        ]);

        OrderItem::create([
            'order_id' => $order6->id,
            'product_id' => $yogurt->id,
            'quantity' => 2,
            'unit_price' => 3.99,
            'subtotal' => 7.98,
        ]);

        OrderItem::create([
            'order_id' => $order6->id,
            'product_id' => $water->id,
            'quantity' => 1,
            'unit_price' => 0.99,
            'subtotal' => 0.99,
        ]);

        $order7 = Order::create([
            'customer_name' => 'Edward Norton',
            'customer_phone' => '+5566778899',
            'delivery_address' => '147 Birch Way, City, State 33333',
            'status' => 'pending',
            'total_price' => 7.47,
            'created_at' => now()->subHours(3),
        ]);

        OrderItem::create([
            'order_id' => $order7->id,
            'product_id' => $potato->id,
            'quantity' => 2,
            'unit_price' => 1.79,
            'subtotal' => 3.58,
        ]);

        OrderItem::create([
            'order_id' => $order7->id,
            'product_id' => $onion->id,
            'quantity' => 1,
            'unit_price' => 1.99,
            'subtotal' => 1.99,
        ]);

        OrderItem::create([
            'order_id' => $order7->id,
            'product_id' => $butter->id,
            'quantity' => 1,
            'unit_price' => 2.99,
            'subtotal' => 2.99,
        ]);

        $order8 = Order::create([
            'customer_name' => 'Fiona Green',
            'customer_phone' => '+6677889900',
            'delivery_address' => '258 Spruce St, City, State 44444',
            'status' => 'delivered',
            'total_price' => 11.97,
            'created_at' => now()->subDays(4),
        ]);

        OrderItem::create([
            'order_id' => $order8->id,
            'product_id' => $grapes->id,
            'quantity' => 1,
            'unit_price' => 5.99,
            'subtotal' => 5.99,
        ]);

        OrderItem::create([
            'order_id' => $order8->id,
            'product_id' => $cheese->id,
            'quantity' => 1,
            'unit_price' => 4.99,
            'subtotal' => 4.99,
        ]);

        $crackers = Product::create([
            'category_id' => $snacks->id,
            'name' => 'Crackers',
            'slug' => 'crackers',
            'description' => 'Saltine crackers, 200g',
            'price' => 2.99,
            'unit' => 'box',
            'stock' => 60,
            'is_active' => true,
        ]);

        OrderItem::create([
            'order_id' => $order8->id,
            'product_id' => $crackers->id,
            'quantity' => 1,
            'unit_price' => 2.99,
            'subtotal' => 2.99,
        ]);
    }
}
