<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutEvents;
use Tests\TestCase;

class UserBanTest extends TestCase
{
    /**
    * @test
    */
    public function a_leader_can_ban_another_user()
    {
        $leader = factory('App\User')->create();
        $leader->organization->update([
            'leader_id' => $leader->id
        ]);
        $user = factory('App\User')->create(['organization_id' => $leader->organization_id ]);
        $this->actingAs($leader)
        ->post(route('users.ban', $user->id))
        ->assertSessionHasNoErrors()
        ->assertStatus(302)
        ->assertSessionHas('message');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'banned_at' => now()->format('Y-m-d H:i:s'),
        ]);
        $this->assertDatabaseHas('bans', [
            'bannable_type' => get_class($user),
            'bannable_id' => $user->id
        ]);
    }

    /**
    * @test
    */
    public function a_leader_can_unban_a_user()
    {
        $leader = factory('App\User')->create();
        $leader->organization->update([
            'leader_id' => $leader->id
        ]);
        $user = factory('App\User')->create(['organization_id' => $leader->organization_id ]);
        $user->ban();
        $this->actingAs($leader)
        ->post(route('users.unban', $user->id))
        ->assertSessionHasNoErrors()
        ->assertStatus(302)
        ->assertSessionHas('message');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'banned_at' => null,
        ]);
    }

    /**
    * @test
    */
    public function a_leader_from_another_organization_cannot_ban_a_user_from_another()
    {
        $leader = factory('App\User')->create();
        $leader->organization->update([
            'leader_id' => $leader->id
        ]);
        $user = factory('App\User')->create();
        $this->actingAs($leader)
        ->post(route('users.ban', $user->id))
        ->assertForbidden(); 

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'banned_at' => null
        ]);
    }


    /**
     * @test
     */
    public function a_leader_from_another_organization_cannot_unban_a_user_from_another()
    {
        $leader = factory('App\User')->create();
        $leader->organization->update([
            'leader_id' => $leader->id
        ]);
        $user = factory('App\User')->create();
        $user->ban(); 
        $this->actingAs($leader)
        ->post(route('users.unban', $user->id))
        ->assertForbidden(); 
        
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'banned_at' => now()->format('Y-m-d H:i:s'),
        ]);
    }
}
