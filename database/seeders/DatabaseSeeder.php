<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\SiteSetting;
use App\Models\Products;
use Database\Factories\ProductsFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            SliderSeeder::class,
            CategorySeeder::class,
            AboutSeeder::class,
            SiteSettingSeeder::class,
            ProductsSeeder::class,
        ]);

        Products::factory(100)->create();
    }
}
