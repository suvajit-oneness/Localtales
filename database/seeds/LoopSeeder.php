<?php

use Illuminate\Database\Seeder;
use App\Models\Loop;

class LoopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Loop::insert([
            ["content"=>"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s","user_id" => '1',"no_of_likes"=>"2","no_of_dislikes"=>"0","no_of_comments"=>"1","status" => 1, "created_at" => '2021-12-26 10:00:00', "updated_at" => '2021-12-26 10:00:00'],
            ["content"=>"It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.","user_id" => '1',"no_of_likes"=>"1","no_of_dislikes"=>"1","no_of_comments"=>"0","status" => 1, "created_at" => '2021-12-26 11:00:00', "updated_at" => '2021-12-26 11:00:00'],
        ]);
    }
}
