<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = collect([
            [
                'name' => 'approve-and-deny-leave',
                'display_name' => 'Approve & Deny Leave',
                'description' => 'Allow the user to approve & deny leave'
            ],
            [
                'name' => 'add-user', 
                'display_name' => 'Add Users', 
                'description' => 'Allows the user to add new users to the organization'
            ], 
            [
                'name' => 'remove-user', 
                'display_name' => 'Remove Users', 
                'description' => 'Allows the user to remove users from the organization'
            ]
        ]);
        $permissions->each(function ($permission) {
            Permission::firstOrCreate($permission);
        });
    }
}
