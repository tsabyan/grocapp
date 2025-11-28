<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\User;
use Carbon\Carbon;
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

        // Create more regular users
        $users = [];
        $userNames = [
            'John Customer', 'Jane Smith', 'Bob Johnson', 'Alice Williams',
            'Charlie Brown', 'Diana Prince', 'Edward Norton', 'Fiona Green',
            'George Harris', 'Helen Davis', 'Ian Wilson', 'Julia Martinez',
            'Kevin Anderson', 'Laura Taylor', 'Michael Thomas', 'Nancy Jackson',
            'Oliver White', 'Patricia Harris', 'Robert Martin', 'Sarah Garcia'
        ];

        foreach ($userNames as $name) {
            $email = strtolower(str_replace(' ', '.', $name)) . '@example.com';
            $users[] = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('password'),
                'is_admin' => false,
                'email_verified_at' => now(),
            ]);
        }

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

        $pantry = Category::create([
            'name' => 'Pantry',
            'slug' => 'pantry',
            'description' => 'Pantry staples and canned goods',
        ]);

        $personalCare = Category::create([
            'name' => 'Personal Care',
            'slug' => 'personal-care',
            'description' => 'Personal hygiene and care products',
        ]);

        // Create products - Fruits (more products)
        $products = [];
        $fruitsData = [
            ['Red Apples', 'red-apples', 'Fresh red apples, sweet and crisp', 2.99, 'kg', 50],
            ['Green Apples', 'green-apples', 'Fresh green apples, tart and crisp', 2.79, 'kg', 45],
            ['Bananas', 'bananas', 'Fresh yellow bananas', 1.99, 'kg', 75],
            ['Oranges', 'oranges', 'Fresh sweet oranges', 3.49, 'kg', 40],
            ['Strawberries', 'strawberries', 'Fresh red strawberries', 4.99, 'pack', 25],
            ['Grapes', 'grapes', 'Fresh green grapes', 5.99, 'kg', 30],
            ['Blueberries', 'blueberries', 'Fresh blueberries', 6.99, 'pack', 20],
            ['Mangoes', 'mangoes', 'Fresh ripe mangoes', 4.49, 'kg', 15],
            ['Pineapples', 'pineapples', 'Fresh pineapples', 3.99, 'piece', 12],
            ['Watermelons', 'watermelons', 'Fresh watermelons', 5.49, 'piece', 8],
            ['Peaches', 'peaches', 'Fresh peaches', 3.99, 'kg', 25],
            ['Pears', 'pears', 'Fresh pears', 3.29, 'kg', 30],
        ];

        foreach ($fruitsData as $fruit) {
            $products[] = Product::create([
                'category_id' => $fruits->id,
                'name' => $fruit[0],
                'slug' => $fruit[1],
                'description' => $fruit[2],
                'price' => $fruit[3],
                'unit' => $fruit[4],
                'stock' => $fruit[5],
                'is_active' => true,
            ]);
        }

        // Create products - Vegetables (more products)
        $vegetablesData = [
            ['Carrots', 'carrots', 'Fresh orange carrots', 1.49, 'kg', 60],
            ['Tomatoes', 'tomatoes', 'Fresh red tomatoes', 2.49, 'kg', 45],
            ['Onions', 'onions', 'Fresh yellow onions', 1.99, 'kg', 55],
            ['Potatoes', 'potatoes', 'Fresh white potatoes', 1.79, 'kg', 70],
            ['Lettuce', 'lettuce', 'Fresh green lettuce', 2.99, 'head', 35],
            ['Broccoli', 'broccoli', 'Fresh broccoli florets', 3.49, 'kg', 30],
            ['Cauliflower', 'cauliflower', 'Fresh cauliflower', 2.99, 'head', 25],
            ['Bell Peppers', 'bell-peppers', 'Fresh bell peppers', 3.99, 'kg', 20],
            ['Cucumbers', 'cucumbers', 'Fresh cucumbers', 1.99, 'kg', 40],
            ['Spinach', 'spinach', 'Fresh spinach leaves', 2.49, 'bunch', 30],
            ['Zucchini', 'zucchini', 'Fresh zucchini', 2.29, 'kg', 25],
            ['Eggplant', 'eggplant', 'Fresh eggplant', 2.79, 'kg', 20],
        ];

        foreach ($vegetablesData as $vegetable) {
            $products[] = Product::create([
                'category_id' => $vegetables->id,
                'name' => $vegetable[0],
                'slug' => $vegetable[1],
                'description' => $vegetable[2],
                'price' => $vegetable[3],
                'unit' => $vegetable[4],
                'stock' => $vegetable[5],
                'is_active' => true,
            ]);
        }

        // Create products - Dairy (more products)
        $dairyData = [
            ['Whole Milk', 'whole-milk', 'Fresh whole milk, 1 liter', 3.49, 'liter', 40],
            ['Skim Milk', 'skim-milk', 'Fresh skim milk, 1 liter', 3.29, 'liter', 35],
            ['Cheddar Cheese', 'cheddar-cheese', 'Sharp cheddar cheese, 250g', 4.99, 'pack', 30],
            ['Mozzarella Cheese', 'mozzarella-cheese', 'Fresh mozzarella, 250g', 4.49, 'pack', 28],
            ['Greek Yogurt', 'greek-yogurt', 'Creamy Greek yogurt, 500g', 3.99, 'pack', 25],
            ['Butter', 'butter', 'Salted butter, 250g', 2.99, 'pack', 50],
            ['Eggs', 'eggs', 'Fresh chicken eggs, 12 pieces', 3.49, 'dozen', 60],
            ['Sour Cream', 'sour-cream', 'Sour cream, 250g', 2.49, 'pack', 30],
            ['Cream Cheese', 'cream-cheese', 'Cream cheese, 200g', 3.29, 'pack', 25],
        ];

        foreach ($dairyData as $dairyItem) {
            $products[] = Product::create([
                'category_id' => $dairy->id,
                'name' => $dairyItem[0],
                'slug' => $dairyItem[1],
                'description' => $dairyItem[2],
                'price' => $dairyItem[3],
                'unit' => $dairyItem[4],
                'stock' => $dairyItem[5],
                'is_active' => true,
            ]);
        }

        // Create products - Beverages (more products)
        $beveragesData = [
            ['Bottled Water', 'bottled-water', 'Pure drinking water, 500ml', 0.99, 'bottle', 100],
            ['Orange Juice', 'orange-juice', 'Fresh orange juice, 1 liter', 2.99, 'bottle', 40],
            ['Apple Juice', 'apple-juice', 'Fresh apple juice, 1 liter', 2.79, 'bottle', 35],
            ['Cola', 'cola', 'Carbonated cola drink, 2 liters', 2.49, 'bottle', 50],
            ['Lemonade', 'lemonade', 'Fresh lemonade, 1 liter', 2.99, 'bottle', 30],
            ['Coffee', 'coffee', 'Ground coffee, 500g', 8.99, 'bag', 20],
            ['Tea', 'tea', 'Black tea, 100 bags', 4.99, 'box', 25],
            ['Energy Drink', 'energy-drink', 'Energy drink, 250ml', 2.99, 'can', 60],
        ];

        foreach ($beveragesData as $beverage) {
            $products[] = Product::create([
                'category_id' => $beverages->id,
                'name' => $beverage[0],
                'slug' => $beverage[1],
                'description' => $beverage[2],
                'price' => $beverage[3],
                'unit' => $beverage[4],
                'stock' => $beverage[5],
                'is_active' => true,
            ]);
        }

        // Create products - Meat & Seafood (more products)
        $meatData = [
            ['Chicken Breast', 'chicken-breast', 'Fresh chicken breast, boneless', 8.99, 'kg', 20],
            ['Chicken Thighs', 'chicken-thighs', 'Fresh chicken thighs', 6.99, 'kg', 18],
            ['Ground Beef', 'ground-beef', 'Fresh ground beef, 80/20', 9.99, 'kg', 15],
            ['Beef Steak', 'beef-steak', 'Fresh beef steak', 14.99, 'kg', 12],
            ['Salmon Fillet', 'salmon-fillet', 'Fresh salmon fillet', 15.99, 'kg', 10],
            ['Tuna Steak', 'tuna-steak', 'Fresh tuna steak', 12.99, 'kg', 8],
            ['Shrimp', 'shrimp', 'Fresh shrimp, 500g', 11.99, 'pack', 15],
            ['Pork Chops', 'pork-chops', 'Fresh pork chops', 7.99, 'kg', 16],
        ];

        foreach ($meatData as $meatItem) {
            $products[] = Product::create([
                'category_id' => $meat->id,
                'name' => $meatItem[0],
                'slug' => $meatItem[1],
                'description' => $meatItem[2],
                'price' => $meatItem[3],
                'unit' => $meatItem[4],
                'stock' => $meatItem[5],
                'is_active' => true,
            ]);
        }

        // Create products - Bakery (more products)
        $bakeryData = [
            ['White Bread', 'white-bread', 'Fresh white bread loaf', 2.49, 'loaf', 30],
            ['Whole Wheat Bread', 'whole-wheat-bread', 'Fresh whole wheat bread', 2.79, 'loaf', 25],
            ['Croissants', 'croissants', 'Fresh butter croissants, 4 pieces', 3.99, 'pack', 25],
            ['Bagels', 'bagels', 'Fresh bagels, 6 pieces', 3.49, 'pack', 20],
            ['Donuts', 'donuts', 'Fresh glazed donuts, 6 pieces', 4.99, 'pack', 18],
            ['Muffins', 'muffins', 'Fresh blueberry muffins, 4 pieces', 4.49, 'pack', 22],
        ];

        foreach ($bakeryData as $bakeryItem) {
            $products[] = Product::create([
                'category_id' => $bakery->id,
                'name' => $bakeryItem[0],
                'slug' => $bakeryItem[1],
                'description' => $bakeryItem[2],
                'price' => $bakeryItem[3],
                'unit' => $bakeryItem[4],
                'stock' => $bakeryItem[5],
                'is_active' => true,
            ]);
        }

        // Create products - Snacks (more products)
        $snacksData = [
            ['Potato Chips', 'potato-chips', 'Crispy potato chips, 200g', 2.99, 'bag', 80],
            ['Chocolate Cookies', 'chocolate-cookies', 'Chocolate chip cookies, 300g', 3.49, 'pack', 45],
            ['Crackers', 'crackers', 'Saltine crackers, 200g', 2.99, 'box', 60],
            ['Pretzels', 'pretzels', 'Salted pretzels, 200g', 2.49, 'bag', 50],
            ['Nuts Mix', 'nuts-mix', 'Mixed nuts, 300g', 5.99, 'pack', 30],
            ['Popcorn', 'popcorn', 'Microwave popcorn, 3 pack', 3.99, 'pack', 40],
        ];

        foreach ($snacksData as $snack) {
            $products[] = Product::create([
                'category_id' => $snacks->id,
                'name' => $snack[0],
                'slug' => $snack[1],
                'description' => $snack[2],
                'price' => $snack[3],
                'unit' => $snack[4],
                'stock' => $snack[5],
                'is_active' => true,
            ]);
        }

        // Create products - Frozen (more products)
        $frozenData = [
            ['Vanilla Ice Cream', 'vanilla-ice-cream', 'Creamy vanilla ice cream, 1 liter', 4.99, 'tub', 35],
            ['Chocolate Ice Cream', 'chocolate-ice-cream', 'Rich chocolate ice cream, 1 liter', 4.99, 'tub', 30],
            ['Frozen Pizza', 'frozen-pizza', 'Margherita frozen pizza', 5.99, 'piece', 20],
            ['Frozen Vegetables', 'frozen-vegetables', 'Mixed frozen vegetables, 500g', 2.99, 'bag', 40],
            ['Frozen Berries', 'frozen-berries', 'Mixed frozen berries, 400g', 4.49, 'bag', 25],
        ];

        foreach ($frozenData as $frozenItem) {
            $products[] = Product::create([
                'category_id' => $frozen->id,
                'name' => $frozenItem[0],
                'slug' => $frozenItem[1],
                'description' => $frozenItem[2],
                'price' => $frozenItem[3],
                'unit' => $frozenItem[4],
                'stock' => $frozenItem[5],
                'is_active' => true,
            ]);
        }

        // Create products - Pantry
        $pantryData = [
            ['Rice', 'rice', 'Long grain rice, 1kg', 3.99, 'bag', 50],
            ['Pasta', 'pasta', 'Spaghetti pasta, 500g', 1.99, 'pack', 60],
            ['Olive Oil', 'olive-oil', 'Extra virgin olive oil, 500ml', 6.99, 'bottle', 30],
            ['Salt', 'salt', 'Table salt, 1kg', 1.49, 'box', 40],
            ['Sugar', 'sugar', 'White sugar, 1kg', 2.49, 'bag', 45],
        ];

        foreach ($pantryData as $pantryItem) {
            $products[] = Product::create([
                'category_id' => $pantry->id,
                'name' => $pantryItem[0],
                'slug' => $pantryItem[1],
                'description' => $pantryItem[2],
                'price' => $pantryItem[3],
                'unit' => $pantryItem[4],
                'stock' => $pantryItem[5],
                'is_active' => true,
            ]);
        }

        // Create stock movements spread across different years and months
        // 2022 data
        $stockMovements2022 = [
            ['2022-01-15', $products[0]->id, 50, 'Initial stock'],
            ['2022-02-10', $products[1]->id, 45, 'Initial stock'],
            ['2022-03-05', $products[2]->id, 75, 'Initial stock'],
            ['2022-04-20', $products[0]->id, -5, 'Sold to customer'],
            ['2022-05-12', $products[3]->id, 40, 'New delivery'],
            ['2022-06-18', $products[4]->id, 25, 'Initial stock'],
            ['2022-07-22', $products[2]->id, -10, 'Sold to customer'],
            ['2022-08-08', $products[5]->id, 30, 'Initial stock'],
            ['2022-09-14', $products[6]->id, 20, 'Initial stock'],
            ['2022-10-30', $products[7]->id, 15, 'Initial stock'],
            ['2022-11-11', $products[8]->id, 12, 'Initial stock'],
            ['2022-12-25', $products[9]->id, 8, 'Initial stock'],
        ];

        // 2023 data
        $stockMovements2023 = [
            ['2023-01-10', $products[10]->id, 25, 'Initial stock'],
            ['2023-02-14', $products[11]->id, 30, 'Initial stock'],
            ['2023-03-20', $products[12]->id, 60, 'Initial stock'],
            ['2023-04-05', $products[13]->id, 45, 'Initial stock'],
            ['2023-05-15', $products[14]->id, 55, 'Initial stock'],
            ['2023-06-22', $products[15]->id, 70, 'Initial stock'],
            ['2023-07-08', $products[16]->id, 35, 'Initial stock'],
            ['2023-08-18', $products[17]->id, 30, 'Initial stock'],
            ['2023-09-25', $products[18]->id, 20, 'Initial stock'],
            ['2023-10-12', $products[19]->id, 40, 'Initial stock'],
            ['2023-11-28', $products[20]->id, 25, 'Initial stock'],
            ['2023-12-05', $products[21]->id, 20, 'Initial stock'],
        ];

        // 2024 data
        $stockMovements2024 = [
            ['2024-01-08', $products[22]->id, 40, 'New delivery'],
            ['2024-02-12', $products[23]->id, 35, 'New delivery'],
            ['2024-03-18', $products[24]->id, 30, 'New delivery'],
            ['2024-04-22', $products[25]->id, 28, 'New delivery'],
            ['2024-05-10', $products[26]->id, 25, 'New delivery'],
            ['2024-06-15', $products[27]->id, 50, 'New delivery'],
            ['2024-07-20', $products[28]->id, 60, 'New delivery'],
            ['2024-08-05', $products[29]->id, 30, 'New delivery'],
            ['2024-09-12', $products[30]->id, 25, 'New delivery'],
            ['2024-10-18', $products[31]->id, 100, 'New delivery'],
            ['2024-11-25', $products[32]->id, 40, 'New delivery'],
            ['2024-12-10', $products[33]->id, 35, 'New delivery'],
        ];

        // 2025 data
        $stockMovements2025 = [
            ['2025-01-15', $products[34]->id, 50, 'New delivery'],
            ['2025-02-20', $products[35]->id, 30, 'New delivery'],
            ['2025-03-10', $products[36]->id, 20, 'New delivery'],
            ['2025-04-05', $products[37]->id, 15, 'New delivery'],
            ['2025-05-18', $products[38]->id, 12, 'New delivery'],
            ['2025-06-22', $products[39]->id, 8, 'New delivery'],
            ['2025-07-08', $products[40]->id, 16, 'New delivery'],
            ['2025-08-14', $products[41]->id, 20, 'New delivery'],
            ['2025-09-20', $products[42]->id, 25, 'New delivery'],
            ['2025-10-12', $products[43]->id, 22, 'New delivery'],
            ['2025-11-18', $products[44]->id, 18, 'New delivery'],
        ];

        // Combine all stock movements
        $allStockMovements = array_merge(
            $stockMovements2022,
            $stockMovements2023,
            $stockMovements2024,
            $stockMovements2025
        );

        // Add some sales movements across different dates
        $salesMovements = [
            ['2022-05-20', $products[0]->id, -3, 'Sold to customer'],
            ['2022-08-15', $products[2]->id, -8, 'Sold to customer'],
            ['2023-02-20', $products[3]->id, -5, 'Sold to customer'],
            ['2023-06-10', $products[5]->id, -4, 'Sold to customer'],
            ['2023-09-15', $products[7]->id, -2, 'Sold to customer'],
            ['2024-01-25', $products[10]->id, -6, 'Sold to customer'],
            ['2024-04-18', $products[12]->id, -10, 'Sold to customer'],
            ['2024-07-12', $products[15]->id, -8, 'Sold to customer'],
            ['2024-10-22', $products[18]->id, -5, 'Sold to customer'],
            ['2025-02-15', $products[22]->id, -7, 'Sold to customer'],
            ['2025-05-25', $products[25]->id, -4, 'Sold to customer'],
            ['2025-08-20', $products[28]->id, -6, 'Sold to customer'],
        ];

        $allStockMovements = array_merge($allStockMovements, $salesMovements);

        foreach ($allStockMovements as $movement) {
            StockMovement::create([
                'product_id' => $movement[1],
                'change' => $movement[2],
                'reason' => $movement[3],
                'created_at' => Carbon::parse($movement[0]),
            ]);
        }

        // Create orders spread across different years and months
        $ordersData = [
            // 2022 orders
            ['2022-01-20', 'John Doe', '+1234567890', '123 Main St, City, State 12345', 'delivered', 8.97, [
                [$products[0]->id, 2, 2.99],
                [$products[2]->id, 1, 1.99],
            ]],
            ['2022-02-15', 'Jane Smith', '+0987654321', '456 Oak Ave, City, State 67890', 'delivered', 15.47, [
                [$products[22]->id, 2, 3.49],
                [$products[42]->id, 2, 2.49],
                [$products[26]->id, 1, 3.49],
            ]],
            ['2022-03-10', 'Bob Johnson', '+1122334455', '789 Pine Rd, City, State 54321', 'delivered', 4.48, [
                [$products[12]->id, 2, 1.49],
                [$products[31]->id, 1, 0.99],
            ]],
            ['2022-04-25', 'Alice Williams', '+2233445566', '321 Elm St, City, State 98765', 'delivered', 28.97, [
                [$products[40]->id, 1, 8.99],
                [$products[13]->id, 2, 2.49],
                [$products[14]->id, 1, 1.99],
            ]],
            ['2022-05-18', 'Charlie Brown', '+3344556677', '654 Maple Dr, City, State 11111', 'cancelled', 12.47, [
                [$products[44]->id, 0.5, 15.99],
                [$products[3]->id, 1, 3.49],
            ]],
            ['2022-06-12', 'Diana Prince', '+4455667788', '987 Cedar Ln, City, State 22222', 'delivered', 18.95, [
                [$products[4]->id, 2, 4.99],
                [$products[24]->id, 2, 3.99],
            ]],
            ['2022-07-08', 'Edward Norton', '+5566778899', '147 Birch Way, City, State 33333', 'delivered', 7.47, [
                [$products[15]->id, 2, 1.79],
                [$products[14]->id, 1, 1.99],
                [$products[25]->id, 1, 2.99],
            ]],
            ['2022-08-22', 'Fiona Green', '+6677889900', '258 Spruce St, City, State 44444', 'delivered', 11.97, [
                [$products[5]->id, 1, 5.99],
                [$products[23]->id, 1, 4.99],
            ]],
            ['2022-09-14', 'George Harris', '+7788990011', '369 Willow Ave, City, State 55555', 'delivered', 22.46, [
                [$products[6]->id, 2, 6.99],
                [$products[27]->id, 1, 3.49],
                [$products[31]->id, 2, 0.99],
            ]],
            ['2022-10-30', 'Helen Davis', '+8899001122', '741 Cherry St, City, State 66666', 'delivered', 9.97, [
                [$products[7]->id, 1, 4.49],
                [$products[8]->id, 1, 3.99],
            ]],
            ['2022-11-18', 'Ian Wilson', '+9900112233', '852 Peach Ln, City, State 77777', 'delivered', 16.47, [
                [$products[9]->id, 1, 5.49],
                [$products[22]->id, 2, 3.49],
                [$products[42]->id, 1, 2.49],
            ]],
            ['2022-12-05', 'Julia Martinez', '+0011223344', '963 Plum Rd, City, State 88888', 'delivered', 13.96, [
                [$products[10]->id, 2, 3.99],
                [$products[23]->id, 1, 4.99],
            ]],

            // 2023 orders
            ['2023-01-15', 'Kevin Anderson', '+1122334455', '159 Apple Way, City, State 99999', 'delivered', 19.95, [
                [$products[11]->id, 2, 3.29],
                [$products[24]->id, 2, 3.99],
                [$products[26]->id, 1, 3.49],
            ]],
            ['2023-02-20', 'Laura Taylor', '+2233445566', '357 Orange St, City, State 00000', 'delivered', 14.47, [
                [$products[12]->id, 3, 1.49],
                [$products[13]->id, 2, 2.49],
                [$products[25]->id, 1, 2.99],
            ]],
            ['2023-03-25', 'Michael Thomas', '+3344556677', '468 Banana Ave, City, State 11111', 'delivered', 25.96, [
                [$products[14]->id, 2, 1.99],
                [$products[15]->id, 3, 1.79],
                [$products[40]->id, 1, 8.99],
            ]],
            ['2023-04-10', 'Nancy Jackson', '+4455667788', '579 Grape Ln, City, State 22222', 'delivered', 8.98, [
                [$products[16]->id, 2, 3.49],
                [$products[17]->id, 1, 2.99],
            ]],
            ['2023-05-18', 'Oliver White', '+5566778899', '680 Berry Rd, City, State 33333', 'delivered', 17.47, [
                [$products[18]->id, 2, 2.29],
                [$products[19]->id, 1, 2.49],
                [$products[22]->id, 2, 3.49],
            ]],
            ['2023-06-22', 'Patricia Harris', '+6677889900', '791 Melon Way, City, State 44444', 'delivered', 12.97, [
                [$products[20]->id, 2, 2.79],
                [$products[21]->id, 1, 2.79],
                [$products[31]->id, 2, 0.99],
            ]],
            ['2023-07-08', 'Robert Martin', '+7788990011', '802 Kiwi St, City, State 55555', 'delivered', 21.46, [
                [$products[22]->id, 3, 3.49],
                [$products[23]->id, 1, 4.99],
                [$products[24]->id, 1, 3.99],
            ]],
            ['2023-08-14', 'Sarah Garcia', '+8899001122', '913 Mango Ave, City, State 66666', 'delivered', 15.96, [
                [$products[25]->id, 2, 2.99],
                [$products[26]->id, 2, 3.49],
                [$products[27]->id, 1, 2.49],
            ]],
            ['2023-09-20', 'John Customer', '+1234567890', '124 Pineapple Ln, City, State 77777', 'delivered', 9.97, [
                [$products[28]->id, 1, 2.49],
                [$products[29]->id, 1, 3.29],
                [$products[30]->id, 1, 2.99],
            ]],
            ['2023-10-12', 'Jane Smith', '+0987654321', '235 Papaya Rd, City, State 88888', 'delivered', 18.95, [
                [$products[31]->id, 3, 0.99],
                [$products[32]->id, 1, 2.99],
                [$products[33]->id, 1, 2.79],
            ]],
            ['2023-11-28', 'Bob Johnson', '+1122334455', '346 Avocado Way, City, State 99999', 'delivered', 11.47, [
                [$products[34]->id, 1, 8.99],
                [$products[35]->id, 1, 2.49],
            ]],
            ['2023-12-15', 'Alice Williams', '+2233445566', '457 Coconut St, City, State 00000', 'delivered', 24.96, [
                [$products[36]->id, 1, 14.99],
                [$products[37]->id, 1, 9.99],
            ]],

            // 2024 orders
            ['2024-01-10', 'Charlie Brown', '+3344556677', '568 Lemon Ave, City, State 11111', 'delivered', 16.47, [
                [$products[38]->id, 1, 11.99],
                [$products[39]->id, 1, 7.99],
            ]],
            ['2024-02-18', 'Diana Prince', '+4455667788', '679 Lime Ln, City, State 22222', 'delivered', 10.97, [
                [$products[40]->id, 1, 2.49],
                [$products[41]->id, 1, 2.79],
                [$products[42]->id, 1, 2.49],
            ]],
            ['2024-03-25', 'Edward Norton', '+5566778899', '780 Tangerine Rd, City, State 33333', 'delivered', 19.95, [
                [$products[43]->id, 2, 3.99],
                [$products[44]->id, 1, 15.99],
            ]],
            ['2024-04-12', 'Fiona Green', '+6677889900', '891 Clementine Way, City, State 44444', 'delivered', 13.96, [
                [$products[45]->id, 1, 3.49],
                [$products[46]->id, 1, 4.49],
                [$products[47]->id, 1, 3.99],
            ]],
            ['2024-05-20', 'George Harris', '+7788990011', '902 Mandarin St, City, State 55555', 'delivered', 17.47, [
                [$products[48]->id, 1, 2.99],
                [$products[49]->id, 1, 5.99],
                [$products[50]->id, 1, 3.99],
            ]],
            ['2024-06-15', 'Helen Davis', '+8899001122', '013 Kumquat Ave, City, State 66666', 'delivered', 11.97, [
                [$products[51]->id, 1, 4.99],
                [$products[52]->id, 1, 4.99],
            ]],
            ['2024-07-22', 'Ian Wilson', '+9900112233', '124 Dragon Fruit Ln, City, State 77777', 'delivered', 14.96, [
                [$products[53]->id, 1, 2.99],
                [$products[54]->id, 1, 4.49],
                [$products[55]->id, 1, 2.99],
            ]],
            ['2024-08-08', 'Julia Martinez', '+0011223344', '235 Starfruit Rd, City, State 88888', 'delivered', 20.95, [
                [$products[56]->id, 1, 3.99],
                [$products[57]->id, 1, 8.99],
                [$products[58]->id, 1, 6.99],
            ]],
            ['2024-09-14', 'Kevin Anderson', '+1122334455', '346 Guava Way, City, State 99999', 'delivered', 15.47, [
                [$products[59]->id, 1, 1.99],
                [$products[60]->id, 1, 6.99],
                [$products[61]->id, 1, 4.99],
            ]],
            ['2024-10-18', 'Laura Taylor', '+2233445566', '457 Passion Fruit St, City, State 00000', 'delivered', 12.97, [
                [$products[62]->id, 1, 2.49],
                [$products[63]->id, 1, 4.99],
                [$products[64]->id, 1, 3.49],
            ]],
            ['2024-11-25', 'Michael Thomas', '+3344556677', '568 Lychee Ave, City, State 11111', 'delivered', 18.95, [
                [$products[65]->id, 1, 3.29],
                [$products[66]->id, 1, 2.99],
                [$products[67]->id, 1, 2.49],
            ]],
            ['2024-12-10', 'Nancy Jackson', '+4455667788', '679 Rambutan Ln, City, State 22222', 'delivered', 9.97, [
                [$products[68]->id, 1, 1.49],
                [$products[69]->id, 1, 2.49],
                [$products[70]->id, 1, 2.99],
            ]],

            // 2025 orders
            ['2025-01-15', 'Oliver White', '+5566778899', '780 Durian Rd, City, State 33333', 'pending', 16.47, [
                [$products[22]->id, 2, 3.49],
                [$products[23]->id, 1, 4.99],
            ]],
            ['2025-02-20', 'Patricia Harris', '+6677889900', '891 Jackfruit Way, City, State 44444', 'confirmed', 19.95, [
                [$products[24]->id, 1, 3.99],
                [$products[25]->id, 1, 2.99],
                [$products[40]->id, 1, 8.99],
            ]],
            ['2025-03-10', 'Robert Martin', '+7788990011', '902 Mangosteen St, City, State 55555', 'pending', 11.97, [
                [$products[26]->id, 1, 3.49],
                [$products[27]->id, 1, 2.49],
            ]],
            ['2025-04-05', 'Sarah Garcia', '+8899001122', '013 Longan Ave, City, State 66666', 'confirmed', 14.96, [
                [$products[28]->id, 1, 2.49],
                [$products[29]->id, 1, 3.29],
                [$products[30]->id, 1, 2.99],
            ]],
            ['2025-05-18', 'John Customer', '+1234567890', '124 Persimmon Ln, City, State 77777', 'delivered', 17.47, [
                [$products[31]->id, 1, 0.99],
                [$products[32]->id, 1, 2.99],
                [$products[33]->id, 1, 2.79],
            ]],
            ['2025-06-22', 'Jane Smith', '+0987654321', '235 Pomegranate Rd, City, State 88888', 'delivered', 20.95, [
                [$products[34]->id, 1, 8.99],
                [$products[35]->id, 1, 2.49],
                [$products[36]->id, 1, 14.99],
            ]],
            ['2025-07-08', 'Bob Johnson', '+1122334455', '346 Fig Way, City, State 99999', 'pending', 13.96, [
                [$products[37]->id, 1, 9.99],
                [$products[38]->id, 1, 11.99],
                [$products[39]->id, 1, 7.99],
            ]],
            ['2025-08-14', 'Alice Williams', '+2233445566', '457 Date St, City, State 00000', 'confirmed', 15.47, [
                [$products[40]->id, 1, 8.99],
                [$products[41]->id, 1, 6.99],
                [$products[42]->id, 1, 2.49],
            ]],
            ['2025-09-20', 'Charlie Brown', '+3344556677', '568 Apricot Ave, City, State 11111', 'delivered', 18.95, [
                [$products[43]->id, 1, 3.99],
                [$products[44]->id, 1, 15.99],
                [$products[45]->id, 1, 3.49],
            ]],
            ['2025-10-12', 'Diana Prince', '+4455667788', '679 Plum Ln, City, State 22222', 'pending', 11.97, [
                [$products[46]->id, 1, 4.49],
                [$products[47]->id, 1, 3.99],
                [$products[48]->id, 1, 2.99],
            ]],
            ['2025-11-18', 'Edward Norton', '+5566778899', '780 Cherry Rd, City, State 33333', 'confirmed', 16.47, [
                [$products[49]->id, 1, 3.99],
                [$products[50]->id, 1, 3.99],
                [$products[51]->id, 1, 4.99],
            ]],
        ];

        foreach ($ordersData as $orderData) {
            $order = Order::create([
                'customer_name' => $orderData[1],
                'customer_phone' => $orderData[2],
                'delivery_address' => $orderData[3],
                'status' => $orderData[4],
                'total_price' => $orderData[5],
                'created_at' => Carbon::parse($orderData[0]),
            ]);

            foreach ($orderData[6] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item[0],
                    'quantity' => $item[1],
                    'unit_price' => $item[2],
                    'subtotal' => $item[1] * $item[2],
                ]);
            }
        }
    }
}
