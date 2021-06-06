<?php

namespace Tests\Feature;

use Tests\TestCase;

class TeamTest extends TestCase
{
    /** @test **/
    public function a_user_can_get_the_current_team()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user)
            ->get(route('team'))
            ->assertOk()
            ->assertJsonStructure(['name', 'numberOfApprovedLeaves', 'users']);
    }

    /** @test **/
    public function a_user_as_a_team_admin_can_update_the_team_name()
    {
        $user = factory('App\User')->create();
        $newTeamName = $this->faker->company;
        $user->attachRole('team-admin', $user->team);
        $this->actingAs($user)
            ->post(route('team.update'), [
                'name' => $newTeamName,
            ])->assertSessionHasNoErrors()
            ->assertOk()
            ->assertJsonStructure(['message']);
        $this->assertDatabaseHas('teams', [
            'id' => $user->team->id,
            'name' => $newTeamName,
        ]);
    }

    /** @test **/
    public function a_user_cannot_update_the_team_name_without_permission()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user)
            ->post(route('team.update'), ['name' => 'NotAllowed'])
            ->assertForbidden();
    }

    /** @test **/
    public function a_user_can_get_a_list_of_all_users_that_can_approve_and_deny_leave()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user)
            ->get(route('team.approvers-and-deniers'))
            ->assertOk();
    }
}
