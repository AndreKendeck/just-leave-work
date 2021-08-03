<?php

namespace App\Imports;

use App\Mail\WelcomeEmail;
use App\Notifications\CannotImportUser;
use App\User;
use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class UserImport implements ToModel, ShouldQueue, WithChunkReading
{
    protected $teamId = null;

    protected $notifyUser = null;

    /**
     * @param integer $teamId
     * @param integer $notifyUser
     */
    public function __construct(int $teamId, int $notifyUser)
    {
        $this->teamId = $teamId;
        $this->$notifyUser = $notifyUser;
    }

    public function chunkSize(): int
    {
        return 10;
    }

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

        /** @var App/User $notifyUser  */
        $notifyUser = User::findOrFail($this->notifyUser);

        if (!filter_var($row[1], FILTER_VALIDATE_EMAIL)) {
            return;
        }

        if ($exists) {
            try {
                $notifyUser->notify(new CannotImportUser("User with the email address {$row[1]} could not be added, [Error - User already exists]"));
            } catch (\Exception $e) {
                return Log::error($e->getMessage());
            }
        }

        try {
            $user = new User([
                'name' => $row[0],
                'email' => $row[1],
                'password' => bcrypt($password),
                'leave_balance' => $row[2] ?? 0,
                'team_id' => $notifyUser->team_id,
            ]);
        } catch (\Exception $e) {
            return Log::error($e->getMessage());
        }

        Mail::to($user->email)->queue(new WelcomeEmail($user, $password));

        try {
            $user->sendEmailVerificationNotification();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return $user;
    }
}
