<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class AdjustLeaveBalances implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Collection
     */
    protected $teams;

    /**
     * @param Collection $users
     */
    public function __construct(Collection $teams)
    {
        $this->teams = $teams;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $this->teams->each(function (\App\Team $team) {

            $settings = $team->settings;

            /**
             * if the last leave added at timestamp and today is greater or equal than
             * @var int days requried by the team settings then run the cron job
             */

            $today = today();
            $overLap = $settings->last_leave_balance_added_at->diffInDays($today) >= $settings->days_until_balance_added;

            if ($overLap) {
                $team->users->each(function (\App\User $user) {
                    $toAdd = $user->team->settings->leave_added_per_cycle;
                    Log::info("A leave of {$toAdd} unit will be added to {$user->name} current leave balance {$user->leave_balance}");
                    $user->increment('leave_balance', $toAdd);
                });

                $team->settings->update([
                    'last_leave_balance_added_at' => now(),
                ]);
            }
        });
    }
}
