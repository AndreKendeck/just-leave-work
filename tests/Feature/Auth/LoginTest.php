<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test **/
    public function a_registered_user_can_login_to_the_application()
    {
        $user = factory('App\User')->create();
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password'
        ])->assertOk()
            ->assertJsonStructure([
                'user', 'message', 'token'
            ]);
    }

    /** @test **/
    public function a_unregistered_user_cannot_login_to_the_application()
    {
        $this->post(route('login'), [
            'email' => 'doesnotexist@mail.com',
            'password' => 'fakrer'
        ])->assertStatus(422)
            ->assertJsonStructure(['errors']);
    }
}
