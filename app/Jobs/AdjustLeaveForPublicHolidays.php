<?php

namespace App\Jobs;

use App\Services\PublicHolidayApi\Response\Holiday;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AdjustLeaveForPublicHolidays implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $leave, $holidays;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(\App\Leave $leave, array $holidays)
    {
        $this->leave = $leave;
        $this->holidays = $holidays;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $daysThatFallInBetween = array_filter($this->holidays, function (Holiday $holiday) {
            return $holiday->getDate()->isBetween($this->leave->from, $this->leave->until);
        });
        $numberOfDaysToAdjust = count($daysThatFallInBetween);
        $this->leave->update([
            'adjustment' => $numberOfDaysToAdjust,
        ]);
    }
}
