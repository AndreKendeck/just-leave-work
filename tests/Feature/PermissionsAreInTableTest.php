<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PermissionsAreInTableTest extends TestCase
{
    /**
    * @test
    */
    public function all_permissions_are_in_seeded_on_the_table()
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
            $this->assertDatabaseHas('permissions' , $permission ); 
        });
    }
}
