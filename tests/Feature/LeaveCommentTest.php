<?php

namespace Tests\Feature;

use App\Mail\Comment\Created;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class LeaveCommentTest extends TestCase
{
    /**
    * @test
    */
    public function a_user_can_comment_on_a_leave_that_is_theirs()
    {
        Mail::fake();
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create([
            'organization_id' => $user->organization_id,
            'user_id' => $user->id
        ]);
            
        $text = $this->faker->words(10, true);
        $response = $this->actingAs($user)
        ->post(route('comments.store'), [
            'leave_id' => $leave->id,
            'text' => $text,
        ])
        ->assertSessionHasNoErrors()
        ->assertOk()
        ->assertJsonStructure(['comment']);
        $comment =  (object) $response->decodeResponseJson('comment');

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'leave_id' => $leave->id,
            'text' => $text,
            'user_id' => $user->id,
        ]);

        Mail::assertQueued(Created::class);
    }
    /**
    * @test
    */
    public function a_leader_can_comment_on_a_leave_even_if_they_dont_own_it()
    {
        Mail::fake();
        $leader = factory('App\User')->create();
        $leader->organization->update([
            'leader_id' => $leader->id
        ]);
        $leader->attachPermission('approve-and-deny-leave', $leader->organization);
        $text = $this->faker->words(10, true);
        $leave = factory('App\Leave')->create(['organization_id' => $leader->organization_id ]);
        $response = $this->actingAs($leader)
        ->post(route('comments.store'), [
            'leave_id' => $leave->id,
            'text' => $text,
        ])->assertSessionHasNoErrors()
        ->assertOk()
        ->assertJsonStructure(['comment']);
        $comment = (object) $response->decodeResponseJson('comment');
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'text' => $text,
            'user_id' => $leader->id,
            'leave_id' => $leave->id
        ]);
        Mail::assertQueued(Created::class);
    }
    /**
    * @test
    */
    public function another_users_cannot_comment_on_leaves_that_is_not_theirs()
    {
        Mail::fake();
        $user = factory('App\User')->create();
        $leave = factory('App\Leave')->create([
            'organization_id' => $user->organization_id,
        ]);
            
        $text = $this->faker->words(10, true);
        $response = $this->actingAs($user)
        ->post(route('comments.store'), [
            'leave_id' => $leave->id,
            'text' => $text,
        ])->assertForbidden();
        Mail::assertNotQueued(Created::class);
    }
    
    /**
    * @test
    */
    public function a_user_can_update_their_comment()
    {
        $user = factory('App\User')->create();
        $comment = factory('App\Comment')->create(['user_id' => $user->id ]);
        $text = $this->faker->words(10, true);
        // sleep is need to make sure that a comment can be updated since PHPUnit works in millisecodns
        sleep(1);
        $response =  $this->actingAs($user)
        ->put(route('comments.update', $comment->id), [
            'text' => $text,
        ])->assertSessionHasNoErrors()
        ->assertOk()
        ->assertJsonStructure(['comment']);
        $comment = (object) $response->decodeResponseJson('comment');
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'text' => $comment->text,
            'user_id' => $user->id
        ]);
        $this->assertTrue($comment->was_edited);
    }

    /**
    * @test
    */
    public function a_user_can_delete_their_comment()
    {
        $user = factory('App\User')->create();
        $comment = factory('App\Comment')->create(['user_id' => $user->id ]);
        $this->actingAs($user)
        ->delete(route('comments.delete', $comment->id))
        ->assertSessionHasNoErrors()
        ->assertOk()
        ->assertJsonStructure(['message']);
        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id
        ]);
    }

    /**
    * @test
    */
    public function a_user_cannot_delete_a_comment_that_doesnt_belong_to_them()
    {
        $user = factory('App\User')->create();
        $comment = factory('App\Comment')->create();
        $this->actingAs($user)
        ->delete(route('comments.delete', $comment->id))
        ->assertForbidden();
    }
}
