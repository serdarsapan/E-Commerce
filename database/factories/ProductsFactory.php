<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categoryId = [1,2,3,4,5,6];
        $sizeList = ['Medium','Large','X-Large'];
        $color = ['White','Black','Green','Blue'];

        $sizeText = $sizeList[random_int(0,2)];
        $colorText = $color[random_int(0,3)];
        return [
            'name' => $colorText.' '.$sizeText.' '.'Product',
            'category_id' => $categoryId[random_int(0,5)],
            'short_text' => 'Short Text Section',
            'price' => random_int(20,100),
            'size' => $sizeText,
            'color' => $colorText,
            'qty' => random_int(10,20),
            'status' => '1',
            'content' => 'Content Section'
        ];
    }
}
