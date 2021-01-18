<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
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
                'name' => 'team-admin',
                'display_name' => 'Team Admin',
                'description' => 'Owner of the Organization'
            ],
            [
                'name' => 'admin',
                'display_name' => 'Application Admin',
                'description' => 'Admin of the Application'
            ]
        ]);

        $roles->each(fn (array $role) => \App\Role::firstOrCreate($role));
    }
}
