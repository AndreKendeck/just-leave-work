<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RolesAreInTableTest extends TestCase
{
    /**
    * @test
    */
    public function all_roles_are_in_the_roles_table()
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
            $this->assertDatabaseHas('roles', $role);
        });
    }
}
