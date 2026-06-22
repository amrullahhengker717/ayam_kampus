<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Promo;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create 1 admin/customer user for testing
        User::factory()->create([
            'name' => 'Test Customer',
            'email' => 'customer@example.com',
            'role' => 'customer',
        ]);

        // Create 1 seller user for testing
        $sellerUser = User::factory()->create([
            'name' => 'Test Seller',
            'email' => 'seller@example.com',
            'role' => 'seller',
        ]);
        
        $testSeller = Seller::factory()->create([
            'user_id' => $sellerUser->id,
            'store_name' => 'Warung Ayam Kampus',
        ]);

        // Create 5 Categories
        $categories = Category::factory(5)->create();

        // Create 10 Sellers
        $sellers = Seller::factory(10)->create();

        // For each seller, create 5-10 products
        foreach ($sellers as $seller) {
            Product::factory(rand(5, 10))->create([
                'seller_id' => $seller->id,
                'category_id' => $categories->random()->id,
            ]);
        }

        // Create some Promos for random products
        $products = Product::inRandomOrder()->take(10)->get();
        foreach ($products as $product) {
            Promo::factory()->create([
                'product_id' => $product->id,
            ]);
        }
    }
}
