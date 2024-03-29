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
                'usePublicHolidays', 
                'country',
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
            'use_public_holidays' => true, 
        ];

        $countryPost = [
            'country' => 'ZA'
        ];

        $user = factory('App\User')->create();

        $user->attachRole('team-admin', $user->team);

        $this->actingAs($user)
            ->put(route('settings.update'),  array_merge($newSettings, $countryPost))
            ->assertSessionHasNoErrors()
            ->assertOk()
            ->assertJsonStructure(['message']);
        $this->assertDatabaseHas('settings', array_merge($newSettings, ['team_id' => $user->team_id], ['country_id' => $countryPost['country']]));
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
            ->put(route('settings.update'), $newSettings)
            ->assertForbidden();
    }
}
