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
            'leave_balance' => rand(1, 10),
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
            'leave_balance' => $newUser['leave_balance'],
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
    public function a_user_can_delete_another_user_with_the_right_permissions()
    {
        $user = factory('App\User')->create();
        $user->attachRole('team-admin', $user->team);
        $userToDelete = factory('App\User')->create(['team_id' => $user->team_id]);
        $this->actingAs($user)
            ->delete(route('users.destroy', $userToDelete->id))
            ->assertOk()
            ->assertJsonStructure(['message']);
        $this->assertSoftDeleted('users', [
            'id' => $userToDelete->id,
        ]);
    }
}
