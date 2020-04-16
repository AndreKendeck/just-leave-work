<?php

namespace Tests\Feature;

use App\Mail\Comment\Created;
use App\Notifications\General;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CommentTest extends TestCase
{
    /**
    * @test
    */
    public function a_user_can_store_a_comment_on_a_leave()
    {
        Mail::fake();
        Notification::fake();
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create(['team_id' => $user->team->id ]);
        $comment = $this->faker->words(10, true);
        $response = $this->actingAs($user)
        ->post(route('api.comments.store'), [
            'leave_id' => $leave->id,
            'text' => $comment
        ])->assertOk()
        ->assertJsonStructure(['message' , 'comment' ]);
        $this->assertDatabaseHas('comments', [
            'leave_id'  => $leave->id,
            'text' => $comment,
            'user_id'  => $user->id,
        ]);
        Notification::assertSentTo($leave->user, General::class);
        Mail::assertQueued(Created::class);
    }

    /**
    * @test
    */
    public function a_user_can_update_a_comment()
    {
        $user = factory('App\User')->create();
        $comment = factory('App\Comment')->create(['user_id' => $user->id ]);
        $newText = $this->faker->words(10, true);
        $this->actingAs($user)
        ->post(route('api.comments.update', $comment->id), [
            'text' => $newText
        ])
        ->assertOk()
        ->assertJsonStructure(['comment' , 'message' ]);
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'text' => $newText,
        ]);
    }

    /**
    * @test
    */
    public function a_user_can_delete_a_comment()
    {
        $user = factory('App\User')->create();
        $comment = factory('App\Comment')->create(['user_id' => $user->id ]);
        $this->actingAs($user)
        ->post(route('api.comments.delete', $comment->id))
        ->assertOk()
        ->assertJsonStructure(['message']);
        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }

    /**
    * @test
    */
    public function user_cannot_store_a_comment_on_a_non_team_comment()
    {
        $user = factory('App\User')->create();
        $user->assignRole('reporter');
        $leave = factory('App\Comment')->create();
        $this->actingAs($user)
        ->post(route('api.comments.store'), [
            'text' => $this->faker->words(10, true),
            'leave_id' => $leave->id
        ])->assertStatus(302)
        ->assertSessionHasErrors();
    }

    /**
    * @test
    */
    public function user_cannot_update_a_non_team_comment()
    {
        $user = factory('App\User')->create();
        $user->assignRole('reporter');
        $comment = factory('App\Comment')->create();
        $this->actingAs($user)
        ->post(route('api.comments.update', $comment->id), [
            'text' => $this->faker->words(10, true),
        ])->assertStatus(403);
    }

    /**
    * @test
    */
    public function user_cannot_delete_a_comment_that_is_not_his_or_hers()
    {
        $user = factory('App\User')->create();
        $user->assignRole('reporter');
        $comment = factory('App\Comment')->create();
        $this->actingAs($user)
        ->post(route('api.comments.delete', $comment->id))->assertStatus(403);
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id
        ]);
    }

    /**
    * @test
    */
    public function user_cannot_delete_a_comment_after_5_minutes()
    {
        $user = factory('App\User')->create();
        $user->assignRole('reporter');
        $comment = factory('App\Comment')->create(['user_id' => $user->id ]);
        $comment->update(['created_at' => now()->subMinutes(20) ]);
        $comment->refresh();
        $this->actingAs($user)
        ->post(route('api.comments.delete', $comment->id))
        ->assertStatus(403);
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id
        ]);
    }

    /**
    * @test
    */
    public function user_cannot_edit_a_comment_after_5_minutes()
    {
        $user = factory('App\User')->create();
        $user->assignRole('reporter');
        $comment = factory('App\Comment')->create(['user_id' => $user->id ]);
        $comment->update(['created_at' => now()->subMinutes(20) ]);
        $this->actingAs($user)
        ->post(route('api.comments.update' , $comment->id ) , [
            'text' => 'something'
        ] )
        ->assertStatus(403)
        ->assertJsonStructure(['errors']); 
    }
}
