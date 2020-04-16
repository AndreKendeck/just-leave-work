<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    /**
    * @test
    */
    public function a_navigate_to_reset_page()
    {
        $this->get(route('password.request'))
        ->assertOk()
        ->assertViewIs('auth.passwords.email');
    }

    /**
    * @test
    */
    public function can_send_password_email()
    {
        $user = factory('App\User')->create();
        $this->post(route('password.email'), [
            'email' => $user->email
        ])
        ->assertStatus(302)
        ->assertSessionHasNoErrors()
        ->assertSessionHas('message');
    }

    /**
    * @test
    */
    public function validates_email()
    {
        $this->post(route('password.email'), [
            'email' => 'wrong'
        ])->assertSessionHasErrors(['email'])
        ->assertStatus(302);
    }

    /**
    * @test
    */
    public function validates_user_exists()
    {
        $this->post(route('password.email'), [
            'email' => 'validbutdoesntexist@mail.com'
        ])->assertStatus(302)
        ->assertSessionHasErrors(['email']);
    }

   
}
