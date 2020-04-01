<?php

namespace Tests\Feature\Api;

use App\Mail\Comment\Created;
use App\Notifications\General;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Support\Facades\Notification;

class CommentControllerTest extends TestCase
{
    /**
    * @test
    */
    public function user_can_add_new_comment_to_a_leave()
    {
        Mail::fake();
        Notification::fake();
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create([
            'user_id' => $user->id,
            'team_id' => $user->team->id,
        ]);
        $text = $this->faker->words(10, true);
        $response = $this->actingAs($user)
        ->post(route('api.comments.store'), [
            'leave_id' => $leave->id,
            'text' => $text,
        ])
        ->assertSessionHasNoErrors()
        ->assertJsonStructure(['message' , 'comment' ]);
        $comment = (object) $response->decodeResponseJson('comment');
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'text' => $text
        ]);
        Notification::assertSentTo($leave->user, General::class);
        Mail::assertQueued( Created::class ); 
    }
}
