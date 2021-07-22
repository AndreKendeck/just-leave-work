<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminUserTest extends TestCase
{
    /** @test **/
    public function user_can_get_a_list_of_all_admins()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user)
            ->get(route('admins.index'))
            ->assertOk();
    }
}
