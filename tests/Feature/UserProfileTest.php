<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    /**
    * @test
    */
    public function a_user_can_go_to_their_profile()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user)
        ->get(route('profile'))
        ->assertOk()
        ->assertViewIs('profile.index');
    }

    /**
    * @test
    */
    public function a_user_can_Update_their_profile()
    {
        Storage::fake();
        $user = factory('App\User')->create();
        $data = [
            'name' => $this->faker->name,
            'avatar' => UploadedFile::fake()->image('profile.jpg')
        ];
        $this->actingAs($user)
        ->post(route('profile.update'), $data)
        ->assertSessionHasNoErrors()
        ->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $data['name'],
            'avatar' => $data['avatar']->hashName()
        ]);
        Storage::assertExists(User::STORAGE_PATH . '/' . $data['avatar']->hashName() );
    }
}
