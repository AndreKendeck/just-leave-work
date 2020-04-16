<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserLeaveTest extends TestCase
{
    
         /**
         * @test
         */
    public function returns_users_leaves()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user)
        ->get(route('user.leave.index', [
            'id' => $user->id,
            'flag' => 0,
        ]))
        ->assertOk()
        ->assertJsonStructure(['leaves']);
    }
}
