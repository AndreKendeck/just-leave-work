<?php

namespace Tests\Feature;

use Tests\TestCase;

class TransactionTest extends TestCase
{
    /** @test **/
    public function a_user_can_view_their_transactions()
    {
        $user = factory('App\User')->create();
        $user->attachRole('team-admin', $user->team);
        $this->actingAs($user)
            ->get(route('transactions.index', ['userId' => $user->id]))
            ->assertOk()
            ->assertJsonStructure(['data', 'from', 'perPage', 'to', 'total', 'currentPage']);
    }

    /** @test **/
    public function transactions_are_a_sum_of_the_user_balance()
    {
        $user = factory('App\User')->create();
        factory('App\Transaction', 10)->create([
            'user_id' => $user->id
        ]);
        $this->assertTrue($user->balance === $user->transactions->sum('amount'));
    }

    /** @test **/
    public function a_transaction_is_created_when_a_leave_is_approved()
    {
        $leave = factory('App\Leave')->create();
        $leave->approve();
        $this->assertDatabaseHas('transactions', [
            'amount' => -$leave->number_of_days_off,
            'user_id' => $leave->user->id
        ]);
    }

    /** @test **/
    public function a_transaction_is_created_when_a_leave_is_denied()
    {
        $leave = factory('App\Leave')->create();
        $leave->deny();
        $this->assertDatabaseHas('transactions', [
            'amount' => 0,
            'user_id' => $leave->user->id
        ]);
    }
}
