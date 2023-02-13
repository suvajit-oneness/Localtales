<?php

use Illuminate\Database\Seeder;
use App\Models\Loopcomment;

class LoopcommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Loopcomment::insert([
            ["user_id" => '1',"loop_id"=>"1","comment"=>"This is a test comment","status" => 1, "created_at" => '2021-12-26 10:30:00', "updated_at" => '2021-12-26 10:30:00'],
        ]);
    }
}
