<?php

namespace Tests\Feature;

use App\Mail\Leave\Approved;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class LeaveApprovalTest extends TestCase
{
    /**
     * @test
     */
    public function a_user_can_approve_a_leave_with_the_right_permissions()
    {
        Mail::fake();
        $user = factory('App\User')->create();
        $user->assignRole('reporter');
        $leave = factory('App\Leave')->create(['reporter_id' => $user->id, 'team_id' => $user->team_id]);
        $this->actingAs($user)
            ->post(route('leaves.approve', [
                'leave_id' => $leave->id,
            ]))->assertStatus(302)
            ->assertSessionHas('message');

        $this->assertDatabaseHas('leaves', [
            'id' => $leave->id,
            'approved_at' => now()->format('Y-m-d H:i:s'),
        ]);
        $this->assertDatabaseHas('approvals', [
            'leave_id' => $leave->id,
            'user_id' => $user->id,
        ]);
        Mail::assertQueued(Approved::class);
    }

    /**
     * @test
     */
    public function user_cannot_approved_leave_without_the_proper_permissions()
    {
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create(['team_id' => $user->team_id]);
        $this->actingAs($user)
            ->post(route('leaves.approve'), [
                'leave_id' => $leave->id,
            ])->assertForbidden();
        $leave->refresh();
        $this->assertFalse($leave->approved);
    }

    /**
     * @test
     */
    public function user_cannot_approve_leave_from_another_team()
    {
        $user = factory('App\User')->create();
        $user->assignRole('reporter');
        $leave = factory('App\Leave')->create();
        $this->actingAs($user)
        ->post(route('leaves.approve') , [
            'leave_id' => $leave->id
        ] )->assertStatus(302)
        ->assertSessionHasErrors('leave_id');
        $leave->refresh();
        $this->assertFalse($leave->approved);

    }
}
