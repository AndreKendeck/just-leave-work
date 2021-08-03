<?php

namespace Tests\Feature;

use Tests\TestCase;

class LeaveTransactionTest extends TestCase
{
    /** @test **/
    public function when_a_leave_is_approved_a_transaction_is_added()
    {
        $leave = factory('App\Leave')->create();
        $leave->approve();
        $this->assertDatabaseHas('transactions', [
            'user_id' => $leave->user->id,
            'amount' => -$leave->number_of_days_off,
        ]);
    }
    /** @test **/
    public function when_a_leave_is_deniend_a_transaction_is_added()
    {
        $leave = factory('App\Leave')->create();
        $leave->deny();
        $this->assertDatabaseHas('transactions', [
            'user_id' => $leave->user->id,
            'amount' => 0,
        ]);
    }
}
