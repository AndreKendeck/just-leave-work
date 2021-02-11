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

            $overLap =  $settings->last_leave_balance_added_at->diffInDays(today()) >= $settings->days_until_balance_added;


            if ($overLap) {
                $team->users->each(function (\App\User $user) use ($settings) {
                    $toAdd = $user->team->settings->leave_added_per_cycle;
                    Log::info("A leave of {$toAdd} unit will be added to {$user->name} current leave balance {$user->leave_balance}");
                    Log::info("The maximum leave balance allowed is {$user->team->settings->maximum_leave_balance} days");
                    /**
                     * if the users leave balance will go over the team limit
                     */
                    $overLimit = ($toAdd + $user->leave_balance) > $settings->maximum_leave_balance;
                    if (!$overLimit) {
                        $user->increment('leave_balance', $toAdd);
                        Log::info("Leave balance for {$user->name} is now {$user->leave_balance}");
                    }

                    if ($overLimit) {
                        $user->update([
                            'leave_balance' => $settings->maximum_leave_balance
                        ]);
                        Log::info("Leave balance for {$user->name} is now {$user->leave_balance}");
                    }
                });

                $team->settings->update([
                    'last_leave_balance_added_at' => now()
                ]);
            }
        });
    }
}
