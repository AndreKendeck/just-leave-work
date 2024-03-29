<?php

namespace Tests\Feature;

use App\Jobs\AdjustLeaveBalances;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class LeaveCronJobTest extends TestCase
{
    /** @test */
    public function cron_job_adds_leave_balances_daily()
    {
        Bus::fake(); 
        $users = factory('App\User', 30)->create();
        $users->each(function (\App\User $user) {
            $user->team->settings->update([
                'days_until_balance_added' => rand(10, 30),
                'last_leave_balance_added_at' => now()->subDays(rand(10, 30)),
                'leave_added_per_cycle' => 2,
            ]);
        });

        $teams = \App\Team::all(); 

        dispatch(new AdjustLeaveBalances($teams));

        $users->each(function (\App\User $user) {
            $currentLeaveBalance = $user->balance + $user->team->leave_added_per_cycle;
            $this->assertTrue($user->balance == $currentLeaveBalance);
        });
    }
}
