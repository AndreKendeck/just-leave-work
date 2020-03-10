<?php

namespace Tests\Feature;

use App\Mail\Leave\Created;
use App\Reason;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mail;

class LeaveTest extends TestCase
{
    /**
    * @test
    */
    public function a_user_can_view_all_their_leaves()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user)
        ->get(route('leaves.index'))
        ->assertOk()
        ->assertViewIs('leaves.index')
        ->assertViewHas('leaves');
    }

    /**
    * @test
    */
    public function a_user_can_create_a_new_leave()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user)
        ->get(route('leaves.create'))
        ->assertOk()
        ->assertViewIs('leaves.create')
        ->assertViewHas('reasons');
    }


    /**
    * @test
    */
    public function a_user_can_store_new_leave()
    {
        Mail::fake();
        $user = factory('App\User')->create();
        $leave = [
            'organization_id' => $user->organization_id,
            'reason_id' => Reason::all()->random()->id,
            'description' => $this->faker->words(10, true),
            'from' => today()->addDays(3)->format('Y-m-d'),
            'until' => today()->addDays(5)->format('Y-m-d'),
        ];
        $this->actingAs($user)
        ->post(route('leaves.store'), $leave)
        ->assertSessionHasNoErrors()
        ->assertStatus(302);
        $this->assertDatabaseHas('leaves', [
            'user_id' => $user->id,
            'organization_id' => $user->organization_id,
            'reason_id' => $leave['reason_id'],
            'description' => $leave['description'],
        ]);
        Mail::assertQueued(Created::class);
    }

    /**
    * @test
    */
    public function a_user_can_only_edit_the_leave_they_created()
    {
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create(['user_id' => $user->id ]);
        $this->actingAs($user)
        ->get(route('leaves.edit', $leave->id))
        ->assertOk()
        ->assertViewIs('leaves.edit')
        ->assertViewHas(['reasons' , 'leave' ]);
    }

    /**
    * @test
    */
    public function a_user_can_update_their_leave()
    {
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create(['user_id' => $user->id ]);
        $data = [
            'reason_id' => Reason::all()->random()->id,
            'description' => $this->faker->words(10, true)
        ];
        $this->actingAs($user)
        ->put(route('leaves.update', $leave->id), $data)
        ->assertSessionHasNoErrors()
        ->assertStatus(302)
        ->assertSessionHas('message');
        $this->assertDatabaseHas('leaves', [
            'user_id' => $user->id,
            'id' => $leave->id,
            'description' => $data['description'],
            'reason_id' => $data['reason_id']
        ]);
    }

    /**
    * @test
    */
    public function a_user_can_view_their_leave()
    {
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create(['user_id' => $user->id ]);
        $this->actingAs($user)
        ->get(route('leaves.show', $leave->id))
        ->assertOk()
        ->assertViewIs('leaves.show')
        ->assertViewHas('leave');
    }

    /**
    * @test
    */
    public function a_leave_can_be_deleted()
    {
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create(['user_id' => $user->id ]);
        $this->actingAs($user)
        ->delete(route('leaves.delete', $leave->id))
        ->assertStatus(302)
        ->assertSessionHas('message');
        $this->assertDatabaseMissing('leaves', [
            'id' => $leave->id
        ]);
    }
    /**
    * @test
    */
    public function a_user_with_the_right_permissions_can_view_a_leave()
    {
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create(['organization_id' => $user->organization_id ]);
        $user->attachPermission('approve-and-deny-leave', $user->organization);
        $this->actingAs($user)
            ->get(route('leaves.show', $leave->id))
            ->assertOk()
            ->assertViewIs('leaves.show')
            ->assertViewHas('leave');
    }

    /**
    * @test
    */
    public function a_leave_cannot_be_deleted_if_approved()
    {
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create(['user_id' => $user->id ]);
        // doesnt matter who approved it at this point
        $leave->approve($user);
        $this->actingAs($user)
        ->delete(route('leaves.delete', $leave))
        ->assertStatus(302)
        ->assertSessionHas('message');
        $this->assertDatabaseHas('leaves', [
            'id' => $leave->id,
        ]);
    }
}
