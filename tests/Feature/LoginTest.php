<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
    * @test
    */
    public function a_guest_can_go_to_the_login_page()
    {
        $this->get(route('login'))
        ->assertOk()
        ->assertViewIs('auth.login');
    }

    /**
    * @test
    */
    public function a_user_can_login()
    {
        $user = factory('App\User')->create();
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password'
        ]);
        $this->assertAuthenticatedAs($user);
    }
    
    /**
    * @test
    */
    public function a_user_can_logout_of_the_application()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user)
        ->post(route('logout'))
        ->assertStatus(302); 
    }
}
