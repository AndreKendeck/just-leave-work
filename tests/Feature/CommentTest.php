<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    /** @test **/
    public function a_user_can_comment_on_a_leave()
    {
        $leave = factory('App\Leave')->create();

        $user = $leave->user;

        $commentText = $this->faker->sentences(5, true);

        $response = $this->actingAs($user)
            ->post(route('comments.store'), [
                'leave_id' => $leave->id,
                'text' => $commentText
            ])->assertCreated()
            ->assertJsonStructure(['message', 'comment']);
        ['comment' => $comment] = $response->json();

        $this->assertDatabaseHas('comments', [
            'id' => $comment['id'],
            'user_id' => $user->id,
            'leave_id' => $leave->id,
            'text' => $commentText
        ]);
    }

    /** @test **/
    public function a_user_can_view_a_comment_from_the_same_team()
    {
        $comment = factory('App\Comment')->create();

        $user = $comment->user;

        $this->actingAs($user)
            ->get(route('comments.show', $comment->id))
            ->assertOk()
            ->assertSessionHasNoErrors()
            ->assertJsonStructure(['comment']);
    }

    /** @test **/
    public function a_user_cannot_view_a_comment_from_a_different_team()
    {
        $user = factory('App\User')->create();
        $comment = factory('App\Comment')->create();
        $this->actingAs($user)
            ->get(route('comments.show', $comment->id))
            ->assertForbidden();
    }

    /** @test **/
    public function a_user_can_update_their_comment_()
    {
        $comment = factory('App\Comment')->create();
        $text = $this->faker->sentences(3, true);
        $response =  $this->actingAs($comment->user)
            ->put(route('comments.update', $comment->id), [
                'text' => $text
            ])->assertSessionHasNoErrors()
            ->assertOk()
            ->assertJsonStructure([
                'message', 'comment'
            ]);
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'text' => $text
        ]);
    }
    /** @test **/
    public function a_user_cannot_update_a_comment_that_has_been_created_more_than_five_minnutes_ago()
    {
        $comment = factory('App\Comment')->create([
            'created_at' => now()->subMinutes(10)
        ]);
        $text = $this->faker->sentences(3, true);
        $this->actingAs($comment->user)
            ->put(route('comments.update', $comment->id), [
                'text' => $text
            ])->assertForbidden()
            ->assertJsonStructure(['message']);
    }

    /** @test **/
    public function a_user_can_delete_their_comnent()
    {
        $comment = factory('App\Comment')->create();
        $this->actingAs($comment->user)
            ->delete(route('comments.destroy', $comment->id))
            ->assertOk()
            ->assertJsonStructure(['message']);
        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id
        ]);
    }

    /** @test **/
    public function a_user_cannot_delete_a_comment_they_do_not_own()
    {
        $comment = factory('App\Comment')->create();
        $user = factory('App\User')->create();
        $this->actingAs($user)
            ->delete(route('comments.destroy', $comment->id))
            ->assertForbidden()
            ->assertJsonStructure(['message']);

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id
        ]);
    }

    /** @test **/
    public function a_user_cannot_delete_a_comment_that_lapsed_5_minutes()
    {
        $comment = factory('App\Comment')->create([
            'created_at' => now()->addMinutes(10)
        ]);
        $this->actingAs($comment->user)
            ->delete(route('comments.destroy', $comment->id))
            ->assertForbidden()
            ->assertJsonStructure(['message']);
    }
}
