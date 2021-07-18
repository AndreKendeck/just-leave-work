<?php

namespace Tests\Feature\Auth;

use App\User;
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
            'terms' => 1,
        ];

        $response = $this->post(route('register'), $details)
            ->assertCreated()
            ->assertJsonStructure(['user', 'token', 'message']);

        ['user' => $user] = $response->json();

        $user = User::find($user['id']);

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
            'team_id' => $user->team->id,
        ]);

        $this->assertDatabaseHas('role_user', [
            'role_id' => 1,
            'user_id' => $user->id,
            'user_type' => get_class($user),
            'team_id' => $user->team->id,
        ]);

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_type' => 'App\User',
            'tokenable_id' => $user->id,
        ]);

        $this->assertDatabaseHas('settings', [
            'team_id' => $user->team->id,
        ]);

        collect(['Saturday', 'Sunday'])->each(function (string $day) use ($user) {
            $this->assertDatabaseHas('excluded_days', [
                'day' => $day,
                'setting_id' => $user->team->settings->id,
            ]);
        });
    }
}
