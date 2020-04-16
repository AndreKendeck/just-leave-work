<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

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
                'name' => 'admin'
            ],
            [
                'name' => 'user'
            ], 
            [
                'name' => 'reporter'
            ]
        ]);
        $roles->each(function ($role) {
            Role::firstOrCreate($role);
        });
    }
}
