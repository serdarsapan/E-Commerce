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
            'image'=> '../frontFiles/images/men.jpg',
            'thumbnail'=> null,
            'name'=>'Men',
            'content'=>'Men Clothes',
            'parent'=> null,
            'status'=>'1'
        ]);

        Category::create([
            'image'=> null,
            'thumbnail'=> null,
            'name'=>'Men Shirts',
            'content'=>'Men Shirts',
            'parent'=> $men->id,
            'status'=>'1'
        ]);

        $women = Category::create([
            'image'=> '../frontFiles/images/women.jpg',
            'thumbnail'=> null,
            'name'=>'Women',
            'content'=>'Women Clothes',
            'parent'=> null,
            'status'=>'1'
        ]);

        Category::create([
            'image'=> null,
            'thumbnail'=> null,
            'name'=>'Women Dresses',
            'content'=>'Women Dresses',
            'parent'=> $women->id,
            'status'=>'1'
        ]);

        $kids = Category::create([
            'image'=> '../frontFiles/images/children.jpg',
            'thumbnail'=> null,
            'name'=>'Kids',
            'content'=>'Kids Clothes',
            'parent'=> null,
            'status'=>'1'
        ]);

        Category::create([
            'image'=> null,
            'thumbnail'=> null,
            'name'=>'Kids Pants/Jeans',
            'content'=>'Kids Pants/Jeans',
            'parent'=> $kids->id,
            'status'=>'1'
        ]);
    }
}
