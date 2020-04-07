<?php

namespace Tests\Feature;

use App\Mail\Leave\Denied;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class LeaveDenialTest extends TestCase
{
    /**
     * @test
     */
    public function a_user_can_deny_a_leave_with_the_right_permissions()
    {
        Mail::fake();
        $user = factory('App\User')->create();
        $user->assignRole('reporter');
        $leave = factory('App\Leave')->create(['reporter_id' => $user->id, 'team_id' => $user->team_id]);
        $this->actingAs($user)
            ->post(route('leaves.deny', [
                'leave_id' => $leave->id,
            ]))->assertStatus(302)
            ->assertSessionHas('message');

        $this->assertDatabaseHas('leaves', [
            'id' => $leave->id,
            'denied_at' => now()->format('Y-m-d H:i:s'),
        ]);
        $this->assertDatabaseHas('denials', [
            'leave_id' => $leave->id,
            'user_id' => $user->id,
        ]);
        Mail::assertQueued(Denied::class);

    }

    /**
     * @test
     */
    public function a_user_cannot_deny_a_leave_without_the_permissions()
    {
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create(['team_id' => $user->team_id]);
        $this->actingAs($user)
            ->post(route('leaves.deny', [
                'leave_id' => $leave->id,
            ]))->assertForbidden();
    }

    /**
     * @test
     */
    public function a_user_cannot_deny_a_leave_from_another_team()
    {
        $user = factory('App\User')->create();
        $user->assignRole('reporter');
        $leave = factory('App\Leave')->create();
        $this->actingAs($user)
            ->post(route('leaves.deny'), [
                'leave_id' => $leave->id,
            ])->assertRedirect()
            ->assertSessionHasErrors('leave_id');
    }
}
