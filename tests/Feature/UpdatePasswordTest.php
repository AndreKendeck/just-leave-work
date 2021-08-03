<?php

namespace Tests\Feature;

use Tests\TestCase;

class UpdatePasswordTest extends TestCase
{
    /** @test **/
    public function a_user_can_update_their_password()
    {
        $user = factory('App\User')->create();
        $password = $this->faker->password(8, 10);
        $this->actingAs($user)->post(route('update.password'), [
            'old_password' => 'password',
            'new_password' => $password,
            'new_password_confirmation' => $password,
        ])->assertSessionHasNoErrors()->assertOk()
            ->assertJsonStructure(['message']);
    }

    /** @test **/
    public function you_cannot_update_your_password_with_the_wrong_current_password()
    {
        $user = factory('App\User')->create();

        $password = $this->faker->password(8, 10);

        $this->actingAs($user)
            ->post(route('update.password'), [
                'old_password' => 'wrongone',
                'new_password' => $password,
                'new_password_confirmation' => $password,
            ])->assertStatus(302);
    }
}
