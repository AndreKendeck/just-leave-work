<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
                'until' => $leave->until->format('Y-m-d')
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
            'team_id' => $user->team->id
        ]);
        $this->actingAs($user)
            ->get(route('leaves.show', $leave->id))
            ->assertOk()
            ->assertJsonStructure(['leave']);
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
            'user_id' => $user->id
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
            'reason_id' => $updates['reason']
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
            'user_id' => $user->id
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
            'user_id' => $user->id
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
            'user_id' => $user->id
        ]);
        $this->actingAs($user)
            ->delete(route('leaves.destroy', $leave->id))
            ->assertOk()
            ->assertJsonStructure(['message']);

        $this->assertDatabaseMissing('leaves', [
            'id' => $leave->id
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
            'id' => $leave->id
        ]);
    }
}
