<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
            ->assertJsonStructure(['name', 'leaves_approved', 'members']);
    }

    /** @test **/
    public function a_user_as_a_team_admin_can_update_the_team_name()
    {
        $user = factory('App\User')->create();
        $newTeamName = $this->faker->company;
        $user->attachRole('team-admin');
        $this->actingAs($user)
            ->post(route('team.update'), [
                'name' => $newTeamName
            ])->assertSessionHasNoErrors()
            ->assertOk()
            ->assertJsonStructure(['message']);
        $this->assertDatabaseHas('teams', [
            'id' => $user->team->id,
            'name' => $newTeamName
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
}
