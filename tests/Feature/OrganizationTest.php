<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrganizationTest extends TestCase
{
    /**
    * @test
    */
    public function a_user_can_view_their_organization()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user)
        ->get(route('organizations.index'))
        ->assertOk()
        ->assertViewHas(['organization' , 'leaves' ])
        ->assertViewIs('organizations.index');
    }

    /**
    * @test
    */
    public function a_owner_can_edit_their_organization()
    {
        $owner = factory('App\User')->create();
        $owner->organization->update([
            'leader_id' => $owner->id
        ]);
        $this->actingAs($owner)
        ->get(route('organizations.edit' , $owner->organization_id ))
        ->assertOk()
        ->assertViewIs('organizations.edit'); 
    }
}
