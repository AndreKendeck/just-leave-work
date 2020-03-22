<?php

namespace Tests\Feature\Auth;

use App\Mail\User\Welcome;
use App\Notifications\General;
use App\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
    * @test
    */
    public function can_navigate_to_register_page()
    {
        $this->get(route('register'))
        ->assertOk()
        ->assertViewIs('auth.register');
    }

    /**
    * @test
    */
    public function can_register_an_account()
    {
        Notification::fake();
        Mail::fake();
        $user = (object) [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'password' => $this->faker->password(8, 10),
            'team_name' => $this->faker->company,
        ];
        $this->post(route('register'), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'team_name' => $user->team_name
        ])->assertStatus(302)
        ->assertSessionHasNoErrors();
        $this->assertAuthenticatedAs(User::where('email', $user->email)->first());
        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'name' => $user->name,
        ]) ;
        $this->assertDatabaseHas('teams', [
            'name' => $user->team_name
        ]);
        Notification::assertSentTo(User::where('email', $user->email)->first() , General::class); 
        Mail::assertQueued(Welcome::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /**
    * @test
    */
    public function validates_request()
    {
        $this->post(route('register'), [
            'name' => '2',
            'email' => 'wrong',
            'password' => 'nope',
            'team_name' => 's'
        ])->assertStatus(302)
        ->assertSessionHasErrors(['email' , 'name' , 'password' , 'team_name']);
    }
}
