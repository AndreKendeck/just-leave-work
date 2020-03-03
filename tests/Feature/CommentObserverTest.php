<?php

namespace Tests\Feature;

use App\Mail\Comment\Created;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Mail;

class CommentObserverTest extends TestCase
{
    /**
    * @test
    */
    public function a_new_email_is_sent_the_leave_requester_when_someone_comments_on_the_leave()
    {
        Mail::fake();
        $comment = factory('App\Comment')->create();
        Mail::assertQueued(Created::class);
    }
}
