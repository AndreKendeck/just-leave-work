<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;

class LeaveTest extends TestCase
{
    /** @test **/
    public function a_user_can_view_all_the_leaves_from_their_team()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user)
            ->get(route('leaves.index'))
            ->assertOk();
    }

    /** @test **/
    public function a_user_can_store_new_leave()
    {

        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->make([
            'team_id' => $user->team->id,
            'user_id' => $user->id,
            'from' => Carbon::create('28-07-2021'),
            'until' => Carbon::create('30-07-2021'),
        ]);
        $this->actingAs($user)
            ->post(route('leaves.store'), [
                'reason' => $leave->reason->id,
                'from' => $leave->from->format('Y-m-d'),
                'until' => $leave->until->format('Y-m-d'),
                'halfDay' => $leave->half_day
            ])->assertSessionHasNoErrors()
            ->assertCreated()
            ->assertJsonStructure(['message', 'leave']);
        $this->assertDatabaseHas('leaves', [
            'user_id' => $user->id,
            'team_id' => $user->team->id,
            'reason_id' => $leave->reason->id,
            'half_day' => $leave->half_day
        ]);
    }

    /** @test **/
    public function users_in_the_same_team_can_view_leaves_as_admin()
    {
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create([
            'team_id' => $user->team->id,
        ]);
        $user->attachRole('team-admin', $user->team);
        $this->actingAs($user)
            ->get(route('leaves.show', $leave->id))
            ->assertOk();
    }

    /** @test **/
    public function users_cannot_view_other_users_leaves_if_they_are_not_admin()
    {
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create([
            'team_id' => $user->team->id,
        ]);
        $this->actingAs($user)
            ->get(route('leaves.show', $leave->id))
            ->assertForbidden();
    }

    /** @test **/
    public function user_can_view_their_leave_if_they_own_it()
    {
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create([
            'team_id' => $user->team->id,
            'user_id' => $user->id,
        ]);
        $this->actingAs($user)
            ->get(route('leaves.show', $leave->id))
            ->assertOk();
    }

    /** @test **/
    public function a_user_not_in_the_same_team_cannot_view_leaves()
    {
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create();
        $this->actingAs($user)
            ->get(route('leaves.show', $leave->id))
            ->assertForbidden()
            ->assertJsonStructure(['message']);
    }




    /** @test **/
    public function a_user_can_delete_their_leave_request()
    {
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create([
            'team_id' => $user->team_id,
            'user_id' => $user->id,
        ]);
        $this->actingAs($user)
            ->delete(route('leaves.destroy', $leave->id))
            ->assertOk()
            ->assertJsonStructure(['message']);

        $this->assertDatabaseMissing('leaves', [
            'id' => $leave->id,
        ]);
    }

    /** @test **/
    public function a_user_cannot_delete_a_leave_request_they_dont_own()
    {
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create();
        $this->actingAs($user)
            ->delete(route('leaves.destroy', $leave->id))
            ->assertForbidden()
            ->assertJsonStructure(['message']);
        $this->assertDatabaseHas('leaves', [
            'id' => $leave->id,
        ]);
    }

    /** @test **/
    public function a_user_cannot_delete_a_leave_that_has_been_approved()
    {
        $leave = factory('App\Leave')->create();
        $leave->approve();
        $this->actingAs($leave->user)
            ->delete(route('leaves.destroy', $leave->id))
            ->assertForbidden();
    }

    /** @test **/
    public function a_user_cannot_delete_a_leave_that_has_been_denied()
    {
        $leave = factory('App\Leave')->create();
        $leave->deny();
        $this->actingAs($leave->user)
            ->delete(route('leaves.destroy', $leave->id))
            ->assertForbidden();
    }

    /** @test **/
    public function a_user_can_approve_leave_with_ther_right_permission()
    {
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create([
            'team_id' => $user->team->id,
        ]);
        $user->attachRole('team-admin', $user->team);
        $this->actingAs($user)
            ->post(route('leaves.approve', $leave->id))
            ->assertOk()
            ->assertJsonStructure(['message']);

        $this->assertDatabaseHas('leaves', [
            'id' => $leave->id,
            'approved_at' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    /** @test **/
    public function a_user_can_deny_leave_with_the_right_permissions()
    {
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create([
            'team_id' => $user->team->id,
        ]);
        $user->attachRole('team-admin', $user->team);
        $this->actingAs($user)
            ->post(route('leaves.deny', $leave->id))
            ->assertOk();
        $this->assertDatabaseHas('leaves', [
            'id' => $leave->id,
            'denied_at' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    /** @test **/
    public function user_cannot_approve_leave_without_permission()
    {
        $leave = factory('App\Leave')->create();
        $this->actingAs($leave->user)
            ->post(route('leaves.approve', $leave->id))
            ->assertForbidden();
    }

    /** @test **/
    public function user_cannot_deny_leave_without_permission()
    {
        $leave = factory('App\Leave')->create();
        $this->actingAs($leave->user)
            ->post(route('leaves.deny', $leave->id))
            ->assertForbidden();
    }
}
