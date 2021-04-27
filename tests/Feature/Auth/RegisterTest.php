<?php

namespace Tests\Feature\Auth;

use App\Permission;
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
            ->assertCreated()
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

        $permissions = Permission::all();

        $permissions->each(function (\App\Permission $permission) use ($user) {
            $this->assertDatabaseHas('permission_user', [
                'permission_id' => $permission->id,
                'user_id' => $user->id,
                'user_type' => get_class($user),
                'team_id' => $user->team->id
            ]);
        });

        $this->assertDatabaseHas('role_user', [
            'role_id' => 1,
            'user_id' => $user->id,
            'user_type' => get_class($user),
            'team_id' => $user->team->id
        ]);


        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_type' => 'App\User',
            'tokenable_id' => $user->id
        ]);

        $this->assertDatabaseHas('settings', [
            'team_id' => $user->team->id
        ]);
    }
}
