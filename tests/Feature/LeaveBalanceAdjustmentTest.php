<?php

namespace Tests\Feature;

use Tests\TestCase;

class LeaveBalanceAdjustmentTest extends TestCase
{
    /** @test **/
    public function a_user_can_adjust_another_users_leave_balance()
    {
        $admin = factory('App\User')->create();

        $user = factory('App\User')->create([
            'team_id' => $admin->team_id,
        ]);

        $admin->attachRole('team-admin', $admin->team);

        $amountAdded = rand(1, 10);

        $this->actingAs($admin)
            ->post(route('leaves.add'), [
                'user' => $user->id,
                'amount' => $amountAdded,
            ])->assertOk()
            ->assertJsonStructure(['message']);


        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'amount' => $amountAdded
        ]);
    }



    /** @test **/
    public function a_user_can_deduct_from_the_leave_balance()
    {
        $admin = factory('App\User')->create();

        $user = factory('App\User')->create([
            'team_id' => $admin->team_id,
        ]);

        $admin->attachRole('team-admin', $admin->team);

        $amountDeducted = rand(1, 10);
        $resultBeing = $user->balance - $amountDeducted;

        $this->actingAs($admin)
            ->post(route('leaves.deduct'), [
                'user' => $user->id,
                'amount' => $amountDeducted,
            ])->assertOk()
            ->assertJsonStructure(['message']);

        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'amount' => -$amountDeducted
        ]);
    }
}
