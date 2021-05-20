<?php

namespace Tests\Feature;

use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class VerifyEmailCodeTest extends TestCase
{
    /** @test **/
    public function a_user_can_have_an_email_code_sent_to_them()
    {
        Mail::fake();
        $user = factory('App\User')->create([
            'email_verified_at' => null,
        ]);
        $this->actingAs($user)
            ->post(route('verify.resend'))
            ->assertOk()
            ->assertJsonStructure(['message']);
        Mail::assertQueued(VerificationEmail::class);
    }

    /** @test **/
    public function a_user_can_verify_their_email_address_using_a_code()
    {

        $user = factory('App\User')->create([
            'email_verified_at' => null,
        ]);

        $code = $user->sendEmailVerificationNotification();

        $this->actingAs($user)
            ->post(route('verify.email'), ['code' => $code])
            ->assertSessionHasNoErrors()
            ->assertOk()
            ->assertJsonStructure(['message']);

        $this->assertTrue($user->hasVerifiedEmail());
    }

    /** @test **/
    public function you_cannot_resend_a_code_if_your_email_address_is_verified()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user)
            ->post(route('verify.resend'))
            ->assertForbidden();
    }

    /** @test **/
    public function you_cannot_verify_your_email_again_if_you_are_already_verified()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user)
            ->post(route('verify.email'), ['code' => 1234])
            ->assertForbidden();
    }
}
