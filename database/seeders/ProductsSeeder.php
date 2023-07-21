<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Products::create([
            'name' => 'Product 1',
            'image' => null,
            'thumbnail' => 'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/fa12b6c4-081f-4475-8209-678029bd22e6/sportswear-mens-tank-top-h9p5SP.png',
            'category_id' => 1,
            'short_text' => 'Short Text 1',
            'price' => 100,
            'size' => 'Large',
            'color' => 'White',
            'qty' => 10,
            'status' => '1',
            'content' => 'Coton 100%',
        ]);
        Products::create([
            'name' => 'Product 2',
            'image' => null,
            'thumbnail' => 'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/9fd97aa5-0812-4087-92f4-be1bf087586b/sportswear-mens-tank-top-h9p5SP.png',
            'category_id' => 2,
            'short_text' => 'Short Text 2',
            'price' => 70,
            'size' => 'X-Large',
            'color' => 'White',
            'qty' => 20,
            'status' => '1',
            'content' => 'Coton 100%',
        ]);
    }
}
