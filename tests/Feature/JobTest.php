<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class JobTest extends TestCase
{
    /** @test **/
    public function the_adjustment_background_job_is_ran_after_a_leave_is_taken_during_a_public_holiday()
    {
        Bus::fake();
        $user = factory('App\User')->create();
        $user->team->settings->update([
            'use_public_holidays' => true,
            'country_id' => 'ZA',
        ]);
        $leave = factory('App\Leave')->make([
            'team_id' => $user->team->id,
            'user_id' => $user->id,
            'from' => Carbon::create(2021,12,13)->format('Y-m-d'),
            'until' => Carbon::create(2021,12,23)->format('Y-m-d'),
        ]);
        $this->actingAs($user)
            ->post(route('leaves.store'), [
                'reason' => $leave->reason->id,
                'from' => $leave->from,
                'leave' => $leave->until,
            ])->assertCreated();
        Bus::assertNotDispatchedAfterResponse(AdjustLeaveForPublicHolidays::class);
    }
}
