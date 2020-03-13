<?php

namespace Tests\Feature;

use App\Mail\User\Banned;
use App\Mail\User\Unbanned;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class BanTest extends TestCase
{

         /**
         * @test
         */
    public function a_user_cannot_be_banned_if_the_user_is_already_banned()
    {
        Mail::fake();
        $user = factory('App\User')->create();
        $user->organization->update(['leader_id' => $user->id ]);
        $bannable = factory('App\User')->create(['organization_id' => $user->organization_id ]);
        $bannable->ban();
        $this->actingAs($user)
        ->post(route('users.ban', $bannable->id))
        ->assertStatus(302)->assertSessionHas('message');
        Mail::assertNotQueued(Banned::class);
    }

    /**
    * @test
    */
    public function a_user_cannot_ban_if_user_is_not_a_leader()
    {
        $user = factory('App\User')->create();
        $bannable = factory('App\User')->create(['organization_id' => $user->organization_id ]);
        $this->actingAs($user)
        ->post(route('users.ban', $bannable->id))
        ->assertForbidden();
    }

    /**
    * @test
    */
    public function a_user_cannot_ban_another_user_from_another_organization()
    {
        $user = factory('App\User')->create();
        $user->organization->update(['leader_id' => $user->id ]);
        $bannable = factory('App\User')->create();
        $this->actingAs($user)
        ->post(route('users.ban', $bannable->id))
        ->assertForbidden();
    }
    /**
    * @test
    */
    public function a_leader_can_unban_another_user()
    {
        Mail::fake();
        $user = factory('App\User')->create();
        $user->organization->update(['leader_id' => $user->id ]);
        $bannable = factory('App\User')->create(['organization_id' => $user->organization_id ]);
        $bannable->ban();
        $this->actingAs($user)
        ->post(route('users.unban', $bannable->id))
        ->assertStatus(302)
        ->assertSessionHas('message');
        $this->assertDatabaseHas('users', [
            'id' => $bannable->id ,
            'banned_at' => null
        ]);
        Mail::assertQueued(Unbanned::class);
    }

    /**
    * @test
    */
    public function a_leader_can_ban_another_user()
    {
        Mail::fake();
        $user = factory('App\User')->create();
        $user->organization->update(['leader_id' => $user->id ]);
        $bannable = factory('App\User')->create(['organization_id' => $user->organization_id ]);
        $this->actingAs($user)
        ->post(route('users.ban', $bannable->id))
        ->assertStatus(302)
        ->assertSessionHas('message');
        $this->assertDatabaseHas('users', [
            'id' => $bannable->id,
            'banned_at' => now()->format('Y-m-d H:i:s')
        ]);
        $this->assertDatabaseHas('bans', [
            'bannable_type' => get_class($bannable),
            'bannable_id' => $bannable->id
        ]);
        Mail::assertQueued(Banned::class, function ($mail) use ($bannable) {
            return $mail->hasTo($bannable->email);
        });
    }
}
