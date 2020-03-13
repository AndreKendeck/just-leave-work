<?php

namespace Tests\Feature;

use App\Notifications\General;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    /**
    * @test
    */
    public function can_view_all_notifications()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user)
        ->get(route('notifications.index'))
        ->assertViewIs('notifications.index')
        ->assertViewHas('notifications');
    }

    /**
    * @test
    */
    public function user_can_read_all_notifications()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user)
        ->get(route('notifications.read'))
        ->assertOk()
        ->assertJsonStructure(['message']);
    }

    /**
    * @test
    */
    public function a_user_can_delete_a_notification()
    {
        $user = factory('App\User')->create();
        $user->notify(new General('Random Notification'));
        $notification = $user->unreadNotifications->first();
        $this->actingAs($user)
        ->delete(route('notifications.delete', $notification->id))
        ->assertOk()
        ->assertJsonStructure(['message']);
        $this->assertDatabaseMissing('notifications', [
            'id' => $notification->id
        ]);
    }
}
