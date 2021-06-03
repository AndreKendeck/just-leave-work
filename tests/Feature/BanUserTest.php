<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BanUserTest extends TestCase
{
    /** @test **/
    public function a_team_leader_can_ban_another_team_member()
    {
        $teamLeader = factory('App\User')->create();
        $teamLeader->attachRole('team-admin');
        $userToBeBlocked = factory('App\User')->create([
            'team_id' => $teamLeader->team->id
        ]);
    }
}
