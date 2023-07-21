<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $marketing = About::create([
            'image'=>'../frontFiles/images/person_3.jpg',
            'name'=> 'Patrick Marx',
            'title'=>'MARKETING',
            'content'=>'Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae aut minima nihil sit distinctio recusandae doloribus ut fugit officia voluptate soluta.',
        ]);

        $sales = About::create([
            'image'=>'../frontFiles/images/person_4.jpg',
            'name'=> 'Mike Coolbert',
            'title'=>'Sales Manager',
            'content'=>'Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae aut minima nihil sit distinctio recusandae doloribus ut fugit officia voluptate soluta.',
        ]);

    }
}
