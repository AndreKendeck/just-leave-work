<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

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
            ], 
        ]); 

        $roles->each( fn(array $role) => Role::firstOrCreate($role) ); 
    }
}
