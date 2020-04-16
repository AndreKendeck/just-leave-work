<?php

namespace App\Jobs;

use App\Mail\User\Invation;
use App\User;
use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class CreateBulkUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $users;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Collection $users)
    {
        $this->users = $users;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->users->each(function ($user) {
            $getName = substr($user, 0, strpos(trim($user), '@'));

            $generator = new ComputerPasswordGenerator();
            $generator->setUppercase()
                ->setLowercase()
                ->setNumbers()
                ->setSymbols(true)
                ->setLength(10);

            $password = $generator->generatePassword();

            $user = User::create([
                'name' => trim($getName),
                'email' => trim($user),
                'team_id' => auth()->user()->team_id,
                'password' => bcrypt($password),
            ]);



            Mail::to($user->email)->queue(new Invation($user, $password));

            $user->sendEmailVerificationNotification(); 
        });
    }
}
