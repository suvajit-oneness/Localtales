<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminsTableSeeder::class);
        $this->call(BannerSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(LoopSeeder::class);
        $this->call(LoopcommentSeeder::class);
        $this->call(CategorySeeder::class);
    }
}
