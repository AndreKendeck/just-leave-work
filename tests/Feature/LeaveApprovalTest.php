<?php

namespace Tests\Feature;

use App\Mail\Leave\Approved;
use App\Mail\Leave\Denied;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class LeaveApprovalTest extends TestCase
{
    /**
    * @test
    */
    public function a_user_with_the_right_permissions_can_approve_leave()
    {
        Mail::fake();
        $user = factory('App\User')->create();
        $user->attachPermission('approve-and-deny-leave', $user->organization);
        $leave = factory('App\Leave')->create(['organization_id' => $user->organization_id ]);
        $this->actingAs($user)
        ->post(route('leaves.approve', $leave->id))
        ->assertSessionHasNoErrors()
        ->assertStatus(302)
        ->assertSessionHas('message');
        $this->assertDatabaseHas('leaves', [
            'id' => $leave->id,
            'approved_by' => $user->id,
        ]);
        Mail::assertQueued(Approved::class);
    }

    /**
    * @test
    */
    public function a_user_cannot_approved_leave_without_ther_right_permissions()
    {
        Mail::fake();
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create(['organization_id' => $user->organization_id ]);
        $this->actingAs($user)
        ->post(
            route('leaves.approve', $leave->id)
        )
        ->assertForbidden();
        $this->assertDatabaseHas('leaves', [
            'id' => $leave->id,
            'approved_at' => null,
            'approved_by' => null,
        ]);
        Mail::assertNotQueued(Approved::class);
    }
    /**
    * @test
    */
    public function a_user_with_right_permissions_can_deny_leave()
    {
        Mail::fake();
        $user = factory('App\User')->create();
        $user->attachPermission('approve-and-deny-leave', $user->organization);
        $leave = factory('App\Leave')->create(['organization_id' => $user->organization_id ]);
        $this->actingAs($user)
        ->post(route('leaves.deny', $leave->id))
        ->assertSessionHasNoErrors()
        ->assertStatus(302)
        ->assertSessionHas('message');
        $this->assertDatabaseHas('leaves', [
            'id' => $leave->id,
            'denied_by' => $user->id,
        ]);
        Mail::assertQueued(Denied::class);
    }


    /**
    * @test
    */
    public function a_user_cannot_deny_leave_without_ther_right_permissions()
    {
        Mail::fake();
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create(['organization_id' => $user->organization_id ]);
        $this->actingAs($user)
        ->post(route('leaves.deny', $leave->id))
        ->assertForbidden();
        $this->assertDatabaseHas('leaves', [
            'id' => $leave->id,
            'denied_at' => null,
            'denied_by' => null,
        ]);
        Mail::assertNotQueued(Approved::class);
    }
}
