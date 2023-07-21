<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $men = Category::create([
            'image'=> null,
            'thumbnail'=> null,
            'name'=>'Men',
            'content'=>'Men Clothes',
            'cat_ust'=> null,
            'status'=>'1'
        ]);

        Category::create([
            'image'=> null,
            'thumbnail'=> null,
            'name'=>'Men Shirts',
            'content'=>'Men Shirts',
            'cat_ust'=> $men->id,
            'status'=>'1'
        ]);

        $women = Category::create([
            'image'=> null,
            'thumbnail'=> null,
            'name'=>'Women',
            'content'=>'Women Clothes',
            'cat_ust'=> null,
            'status'=>'1'
        ]);

        Category::create([
            'image'=> null,
            'thumbnail'=> null,
            'name'=>'Women Dresses',
            'content'=>'Women Dresses',
            'cat_ust'=> $women->id,
            'status'=>'1'
        ]);

        $kids = Category::create([
            'image'=> null,
            'thumbnail'=> null,
            'name'=>'Kids',
            'content'=>'Kids Clothes',
            'cat_ust'=> null,
            'status'=>'1'
        ]);

        Category::create([
            'image'=> null,
            'thumbnail'=> null,
            'name'=>'Kids Pants/Jeans',
            'content'=>'Kids Pants/Jeans',
            'cat_ust'=> $kids->id,
            'status'=>'1'
        ]);
    }
}
