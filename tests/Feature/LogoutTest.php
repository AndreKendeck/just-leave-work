<?php

namespace Tests\Feature;

use Tests\TestCase;

class LogoutTest extends TestCase
{
    /** @test **/
    public function a_user_logouts_are_tokens_are_deleted()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user)
            ->post(route('logout'))
            ->assertOk()
            ->assertJsonStructure(['message']);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_type' => get_class($user),
            'tokenable_id' => $user->id,
        ]);
    }
}
