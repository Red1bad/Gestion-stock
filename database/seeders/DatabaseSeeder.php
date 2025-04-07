<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(1)->create();

        // Create suppliers, stores, and categories
        $suppliers = Supplier::factory()->count(100)->create();
        $stores = Store::factory()->count(5)->create();
        $categories = Category::factory()->count(10)->create();

        // Create products with random suppliers and categories
        $products = Product::factory()
            ->count(100)
            ->state(fn () => [
                'supplier_id' => $suppliers->random()->id,
                'category_id' => $categories->random()->id,
            ])
            ->create();

        // Create 20 customers
        $customers = Customer::factory()->count(100)->create();

        // Distribute 30 orders among the 20 customers
        $orders = collect();
        foreach ($customers as $customer) {
            $customerOrdersCount = rand(1, 3); // Each customer has 1-3 orders
            $customerOrders = Order::factory()->count($customerOrdersCount)->create([
                'customer_id' => $customer->id,
            ]);
            $orders = $orders->merge($customerOrders);
        }

        // Ensure exactly 30 orders
        // $orders = $orders->take(30);

        // Stock products in stores
        foreach ($products as $product) {
            Stock::factory()
                ->count(1) // Each product may be in 1-3 stores
                ->state(fn () => [
                    'product_id' => $product->id,
                    'store_id' => $stores->random()->id,
                ])
                ->create();
        }

        // Attach products to orders using `productOrd()`
        foreach ($orders as $order) {
            $randomProducts = $products->random(rand(1, 5)); // Each order has 1-5 products

            foreach ($randomProducts as $product) {
                $order->productOrd()->attach($product->id, [
                    'price' => $product->price, // Use the product's price
                    'quantity' => rand(1, 10), // Random quantity between 1 and 10
                ]);
            }
        }
    }
}
