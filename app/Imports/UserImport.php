<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;
use App\Mail\WelcomeEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\CannotImportUser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserImport implements ToModel, ShouldQueue
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $passwordGenerator = new ComputerPasswordGenerator();

        $passwordGenerator->setUppercase()
            ->setLowercase()
            ->setNumbers()
            ->setSymbols()
            ->setLength(10);

        $password = $passwordGenerator->generatePassword();

        $exists = User::where('email', $row[1])->exists();

        if ($exists) {
            try {
                auth()->user()->notify(new CannotImportUser("User with the email address {$row[1]} could not be added, [Error - User already exists]"));
            } catch (\Exception $e) {
                return Log::error($e->getMessage());
            }
        }

        $user = new User([
            'name' => $row[0],
            'email' => $row[1],
            'password' => bcrypt($password),
            'leave_balance' => $row[2] ?? 0,
            'team_id' => auth()->user()->team->id
        ]);

        Mail::to($user->email)->queue(new WelcomeEmail($user, $password));

        try {
            $user->sendEmailVerificationNotification();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return $user;
    }
}
