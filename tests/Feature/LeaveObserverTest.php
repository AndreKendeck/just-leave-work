<?php

namespace Tests\Feature;

use App\Mail\Leave\Created;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class LeaveObserverTest extends TestCase
{
    /**
    * @test
    */
    public function a_new_leave_sends_an_email_to_users_that_can_approve_or_deny_leave()
    {
        Mail::fake();
        $leave = factory('App\Leave')->create();
        Mail::assertQueued(Created::class);
    }
}
