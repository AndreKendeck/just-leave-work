<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /** @test **/
    public function a_user_can_register_for_an_account()
    {
        $details = [
            'team_name' => $this->faker->company,
            'email' => $this->faker->companyEmail,
            'password' => 'password123',
            'name' => $this->faker->name,
        ];

        $response = $this->post(route('register'), $details)
            ->assertOk()
            ->assertJsonStructure(['user', 'token', 'message']);

        ['user' => $user] = $response->json();

        $user = User::find($user['id']);

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
            'team_id' => $user->team->id
        ]);
        $this->assertDatabaseHas('teams', [
            'name' => $user->team->name
        ]);

        $this->assertDatabaseHas('settings', [
            'team_id' => $user->team->id
        ]);
    }
}
