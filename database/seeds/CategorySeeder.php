<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            ["title"=>"Accommodation","image" => 'cat1.png',"status" => 1, "created_at" => '2022-01-01 00:00:00', "updated_at" => '2022-01-01 00:00:00'],
            ["title"=>"Food & Beverages","image" => 'cat2.png',"status" => 1, "created_at" => '2022-01-01 00:00:00', "updated_at" => '2022-01-01 00:00:00'],
            ["title"=>"Religion","image" => 'cat3.png',"status" => 1, "created_at" => '2022-01-01 00:00:00', "updated_at" => '2022-01-01 00:00:00'],
            ["title"=>"Government","image" => 'cat4.png',"status" => 1, "created_at" => '2022-01-01 00:00:00', "updated_at" => '2022-01-01 00:00:00'],
            ["title"=>"Adult","image" => 'cat5.png',"status" => 1, "created_at" => '2022-01-01 00:00:00', "updated_at" => '2022-01-01 00:00:00'],
            ["title"=>"Restaurants","image" => 'cat6.png',"status" => 1, "created_at" => '2022-01-01 00:00:00', "updated_at" => '2022-01-01 00:00:00'],
            ["title"=>"Automotive","image" => 'cat7.png',"status" => 1, "created_at" => '2022-01-01 00:00:00', "updated_at" => '2022-01-01 00:00:00'],
        ]);
    }
}
