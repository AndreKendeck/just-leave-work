<?php

namespace Tests\Feature;

use App\Organization;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
    * @test
    */
    public function a_user_had_all_permission_when_they_register_their_account()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'company' => $this->faker->company
        ];
        $this->post(route('register'), [
            'name' => $data['name'],
            'email' => $data['email'],
            'organization_name' =>  $data['company'],
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])
        ->assertSessionHasNoErrors()
        ->assertStatus(302);

        $this->assertAuthenticated('web');
        $this->assertDatabaseHas('users', [
            'organization_id' => 1,
            'email' => $data['email']
        ]);
        $this->assertDatabaseHas('organizations', [
            'display_name' => $data['company']
        ]);

        $user = User::where('email', $data['email'])->get()->first();
        $organization = Organization::where('display_name' , $data['company'] )->get()->first();
        $this->assertTrue($user->hasPermission('approve-and-deny-leave' , $organization ));
        $this->assertTrue($user->is_leader); 
        $this->assertTrue($user->hasPermission('add-user' , $organization ));
        $this->assertTrue($user->hasPermission('remove-user'  , $organization));
    }
}
