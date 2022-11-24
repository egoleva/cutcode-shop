<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        BrandFactory::new()->count(20)->create();
        CategoryFactory::new()->count(20)->create();
        CategoryFactory::new()->count(10)
            ->has(Product::factory(rand(5,15)))
            ->create();


        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
