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
        $this->call(ReasonTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        // only for testing
        $this->call(TestDataSeeder::class); 
    }
}
