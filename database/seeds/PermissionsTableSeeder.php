<?php

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
                'name' => 'can-approve-leave',
                'display_name' => 'Can approve leave',
                'description' => 'Allow the user to approve leave'
            ],
            [
                'name' => 'can-deny-leave',
                'display_name' => 'Can Deny Leave',
                'description' => 'Allow the user to deny leave'
            ],
            [
                'name' => 'can-delete-users',
                'display_name' => 'Can remove users',
                'description' => 'Allow the user to remove users'
            ],
            [
                'name' => 'can-add-users',
                'display_name' => 'Can add users',
                'description' => 'Allow the user to add users'
            ]
        ]);
        $permissions->each(fn (array $permission) => \App\Permission::firstOrCreate($permission));
    }
}
