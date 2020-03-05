<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = collect([
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'The Administrator of the application'
            ],
            [
                'name' => 'user',
                'display_name' => 'User',
                'description' => 'The User of the application'
            ]
        ]);
        $roles->each(function ($role) {
            Role::firstOrCreate($role); 
        });
    }
}
