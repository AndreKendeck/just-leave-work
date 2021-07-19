<?php

namespace Tests\Feature;

use Tests\TestCase;

class TeamSettingsTest extends TestCase
{
    /** @test **/
    public function a_user_can_get_the_teams_settings()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user)
            ->get(route('settings'))
            ->assertOk()
            ->assertJsonStructure([
                'id',
                'teamId',
                'leaveAddedPerCycle',
                'daysUntilBalanceAdded',
                'lastLeaveBalanceAddedAt',
                'createdAt',
                'updatedAt',
            ]);
    }

    /** @test **/
    public function a_user_team_admin_can_update_the_team_settings()
    {
        $newSettings = [
            'leave_added_per_cycle' => rand(1, 5),
            'days_until_balance_added' => rand(15, 30),
        ];

        $user = factory('App\User')->create();

        $user->attachRole('team-admin', $user->team);

        $this->actingAs($user)
            ->post(route('settings.update'), $newSettings)
            ->assertSessionHasNoErrors()
            ->assertOk()
            ->assertJsonStructure(['message']);
        $this->assertDatabaseHas('settings', array_merge($newSettings, ['team_id' => $user->team_id]));
    }

    /** @test **/
    public function a_user_that_is_not_a_team_admin_cannot_update_team_settings()
    {
        $user = factory('App\User')->create();
        $newSettings = [
            'leave_added_per_cycle' => rand(1, 5),
            'days_until_balance_added' => rand(15, 30),
        ];

        $this->actingAs($user)
            ->post(route('settings.update'), $newSettings)
            ->assertForbidden();
    }
}
