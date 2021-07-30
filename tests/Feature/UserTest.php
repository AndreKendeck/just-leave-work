<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test **/
    public function a_user_can_view_themselves()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user)
            ->get(route('users.index'))
            ->assertOk();
    }

    /** @test **/
    public function a_user_can_view_a_another_user_in_the_same_team()
    {
        $user = factory('App\User')->create();
        $jeff = factory('App\User')->create([
            'team_id' => $user->team->id,
        ]);
        $user->attachRole('team-admin', $user->team);
        $this->actingAs($user)
            ->get(route('users.show', $jeff->id))
            ->assertOk();
    }

    /** @test **/
    public function a_team_admin_can_add_a_new_user()
    {
        $user = factory('App\User')->create();
        $user->attachRole('team-admin', $user->team);

        $newUser = [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'balance' => rand(1, 10),
            'is_admin' => $this->faker->randomElement([null, true]),
        ];
        $response = $this->actingAs($user)
            ->post(route('users.store'), $newUser)
            ->assertSessionHasNoErrors()
            ->assertCreated()
            ->assertJsonStructure(['message', 'user']);

        ['user' => $createdUser] = $response->json();

        $this->assertDatabaseHas('users', [
            'team_id' => $user->team->id,
            'name' => $newUser['name'],
            'email' => $newUser['email'],
            'leave_balance' => $newUser['balance'],
        ]);
        if ($newUser['is_admin']) {
            $this->assertDatabaseHas('role_user', [
                'user_id' => $createdUser['id'],
                'user_type' => get_class($user),
                'team_id' => $user->team->id,
            ]);
        }
        $createdUser = User::find($createdUser['id']);
    }

    /** @test **/
    public function you_cannot_view_a_user_thats_not_in_your_teams()
    {
        $user = factory('App\User')->create();
        $cannotViewThisUser = factory('App\User')->create();
        $this->actingAs($user)
            ->get(route('users.show', $cannotViewThisUser->id))
            ->assertForbidden()
            ->assertJsonStructure(['message']);
    }

    /** @test **/
    public function a_team_admin_can_update_a_user()
    {
        $user = factory('App\User')->create();
        $user->attachRole('team-admin', $user->team);
        $userToUpdate = factory('App\User')->create([
            'team_id' => $user->team->id,
        ]);
        $updates = [
            'is_admin' => true,
        ];
        $this->actingAs($user)
            ->put(route('users.update', $userToUpdate->id), $updates)
            ->assertOk()
            ->assertJsonStructure(['message']);

        $this->assertTrue($userToUpdate->hasRole('team-admin', $userToUpdate->team->id));
    }

    /** @test **/
    public function an_admin_can_ban_a_user()
    {
        $admin = factory('App\User')->create();
        $admin->attachRole('team-admin', $admin->team);
        $userToBeBanned = factory('App\User')->create([
            'team_id' => $admin->team->id
        ]);
        $this->actingAs($admin)
            ->post(route('users.ban', ['id' => $userToBeBanned->id]))
            ->assertOk();
        $this->assertDatabaseHas('users', [
            'banned_at' => now()
        ]);
    }

    /** @test **/
    public function a_non_admin_user_cannot_ban_a_user()
    {
        $user = factory('App\User')->create();
        $anotherUser = factory('App\User')->create([
            'team_id' => $user->team->id
        ]);
        $this->actingAs($user)
            ->post(route('users.ban', ['id' => $anotherUser->id]))
            ->assertForbidden();
    }

    /** @test **/
    public function a_admin_can_unban_another_user()
    {
        $admin = factory('App\User')->create();
        $admin->attachRole('team-admin', $admin->team);
        $userToBeBanned = factory('App\User')->create([
            'team_id' => $admin->team->id
        ]);
        $userToBeBanned->ban();
        $this->actingAs($admin)
            ->post(route('users.unban', ['id' => $userToBeBanned->id]))
            ->assertOk();
        $this->assertDatabaseHas('users', [
            'banned_at' => null
        ]);
    }
}
