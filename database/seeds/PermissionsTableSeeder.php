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
                'name' => 'approve-leave',
                'display_name' => 'Approve Leave',
                'description' => 'Allow the user to approve leave'
            ],
            [
                'name' => 'deny-leave',
                'display_name' => 'Deny Leave',
                'description' => 'Allows the user to deny leave'
            ]
        ]);
        $permissions->each(function ($permission) {
            Permission::firstOrCreate($permission);
        });
    }
}
