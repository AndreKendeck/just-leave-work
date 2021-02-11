<?php

namespace Tests\Feature;

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
        ]);
        $this->actingAs($user)
            ->post(route('leaves.store'), [
                'reason' => $leave->reason->id,
                'description' => $leave->description,
                'from' => $leave->from->format('Y-m-d'),
                'until' => $leave->until->format('Y-m-d'),
            ])->assertSessionHasNoErrors()
            ->assertCreated()
            ->assertJsonStructure(['message', 'leave']);
        $this->assertDatabaseHas('leaves', [
            'user_id' => $user->id,
            'team_id' => $user->team->id,
            'reason_id' => $leave->reason->id,
            'description' => $leave->description,
        ]);
    }

    /** @test **/
    public function users_in_the_same_team_can_view_leaves()
    {
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create([
            'team_id' => $user->team->id,
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
    public function a_user_can_update_their_leave()
    {
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create([
            'team_id' => $user->team_id,
            'user_id' => $user->id,
        ]);

        $updates = [
            'from' => today()->format('Y-m-d'),
            'until' => today()->addDays(3)->format('Y-m-d'),
            'description' => $this->faker->words(10, true),
            'reason' => \App\Reason::all()->random()->id,
        ];
        $this->actingAs($leave->user)
            ->put(route('leaves.update', $leave->id), $updates)
            ->assertSessionHasNoErrors()
            ->assertOk()
            ->assertJsonStructure(['message', 'leave']);
        $this->assertDatabaseHas('leaves', [
            'id' => $leave->id,
            'description' => $updates['description'],
            'reason_id' => $updates['reason'],
        ]);
    }

    /** @test **/
    public function a_user_cannot_update_leave_they_dont_own()
    {
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create();
        $updates = [
            'from' => today()->format('Y-m-d'),
            'until' => today()->addDays(3)->format('Y-m-d'),
            'description' => $this->faker->words(10, true),
            'reason' => \App\Reason::all()->random()->id,
        ];
        $this->actingAs($user)
            ->put(route('leaves.update', $leave->id), $updates)
            ->assertForbidden()
            ->assertJsonStructure(['message']);
    }

    /** @test **/
    public function a_user_cannot_update_leave_when_its_approved()
    {
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create([
            'team_id' => $user->team_id,
            'user_id' => $user->id,
        ]);
        $leave->approve();
        $updates = [
            'from' => today()->format('Y-m-d'),
            'until' => today()->addDays(3)->format('Y-m-d'),
            'description' => $this->faker->words(10, true),
            'reason' => \App\Reason::all()->random()->id,
        ];
        $this->actingAs($user)
            ->put(route('leaves.update', $leave->id), $updates)
            ->assertForbidden()
            ->assertJsonStructure(['message']);
    }

    /** @test **/
    public function a_user_cannot_update_leave_when_its_denied()
    {
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create([
            'team_id' => $user->team_id,
            'user_id' => $user->id,
        ]);
        $leave->deny();
        $updates = [
            'from' => today()->format('Y-m-d'),
            'until' => today()->addDays(3)->format('Y-m-d'),
            'description' => $this->faker->words(10, true),
            'reason' => \App\Reason::all()->random()->id,
        ];
        $this->actingAs($user)
            ->put(route('leaves.update', $leave->id), $updates)
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
        $user->attachPermission('can-approve-leave', $user->team);
        $leave = factory('App\Leave')->create([
            'team_id' => $user->team->id,
        ]);
        $this->actingAs($user)
            ->post(route('leaves.approve', $leave->id))
            ->assertOk()
            ->assertJsonStructure(['message']);

        $this->assertDatabaseHas('leaves', [
            'id' => $leave->id,
            'approved_at' => now(),
        ]);
    }

    /** @test **/
    public function a_user_cannot_approve_their_own_leave_if_the_team_does_not_allow_it()
    {
        $user = factory('App\User')->create();

        $leave = factory('App\Leave')->create([
            'team_id' => $user->team->id,
            'user_id' => $user->id,
        ]);

        $leave->team->settings->update(['can_approve_own_leave' => false]);

        $user->attachPermission('can-approve-leave');

        $this->actingAs($user)
            ->post(route('leaves.approve', $leave->id))
            ->assertForbidden()
            ->assertJsonStructure(['message']);
    }

    /** @test **/
    public function a_user_can_deny_leave_with_the_right_permissions()
    {
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create([
            'team_id' => $user->team->id,
        ]);
        $user->attachPermission('can-deny-leave' , $user->team);
        $this->actingAs($user)
            ->post(route('leaves.deny', $leave->id))
            ->assertOk();
        $this->assertDatabaseHas('leaves', [
            'id' => $leave->id,
            'denied_at' => now(),
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

    /** @test **/
    public function a_user_cannot_request_leave_for_more_than_the_days_set_by_the_team_admin()
    {
        $user = factory('App\User')->create();

        $user->team->settings->update([
            'maximum_leave_days' => 5,
        ]);

        $leave = factory('App\Leave')->make([
            'team_id' => $user->team->id,
            'user_id' => $user->id,
            'from' => today(),
            'until' => today()->addDays(10),
        ]);

        $this->actingAs($user)
            ->post(route('leaves.store'), [
                'reason' => $leave->reason->id,
                'description' => $leave->description,
                'from' => $leave->from->format('Y-m-d'),
                'until' => $leave->until->format('Y-m-d'),
            ])->assertForbidden()
            ->assertJsonStructure(['message']);
    }
}
