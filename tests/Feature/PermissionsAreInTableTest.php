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
            $this->assertDatabaseHas('permissions' , $permission ); 
        });
    }
}
