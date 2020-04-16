<?php

namespace App\Jobs;

use App\Mail\Organization\Ban;
use App\Organization;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailToBannedOrganization implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $organization;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Organization $organization)
    {
        $this->organization = $organization;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->organization->users->each(function ($user) {
            Mail::to($user->email)->
            queue(new Ban($this->organization));
        });
    }
}
