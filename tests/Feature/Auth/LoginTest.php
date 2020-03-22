<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
    * @test
    */
    public function can_nagivate_to_the_login_page()
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
        ])->assertStatus(302)
        ->assertSessionHasNoErrors();
        $this->assertAuthenticatedAs($user);
    }

    /**
    * @test
    */
    public function cannot_submit_empty_login_form()
    {
        $this->post(route('login'), [
            'email' => null,
            'password'
        ])->assertSessionHasErrors(['email' , 'password' ])
        ->assertStatus(302);
    }
    
    /**
    * @test
    */
    public function cannot_login_with_invalid_credientials()
    {
        $user = factory('App\User')->create();
        $this->post(route('login') , [
            'email' => $user->email, 
            'password' => $this->faker->password, 
        ] )
        ->assertSessionHasErrors(['email'])
        ->assertStatus(302); 
    }
}
