<?php

namespace Tests\Feature\Admin;

use App\Jobs\SendEmailToBannedOrganization;
use App\Jobs\SendEmailToUnbannedOrganization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class BanTest extends TestCase
{
    /**
    * @test
    */
    public function all_listings_include_banned_users()
    {
        $admin = factory('App\User')->create(['organization_id' => null ]);
        $admin->attachRole('admin');
        $response = $this->actingAs($admin)
        ->get(route('admin.bans.index'))
        ->assertViewIs('admin.bans.index')
        ->assertOk()
        ->assertViewHas('organizations');
    }

    /**
    * @test
    */
    public function a_admin_can_ban_an_organization()
    {
        Bus::fake();
        $organizations = factory('App\Organization', 3)->create();
        $random = $organizations->random();
        $admin = factory('App\User')->create(['organization_id' => null ]);
        $admin->attachRole('admin');
        $this->actingAs($admin)
        ->post(route('admin.bans.store'), [
            'organization_id' => $random->id,
        ])->assertSessionHasNoErrors()
        ->assertStatus(302);
        $this->assertDatabaseHas('organizations', [
            'id' => $random->id,
            'banned_at' => now()->format('Y-m-d H:i:s')
        ]);
        Bus::assertDispatched(SendEmailToBannedOrganization::class);
    }

    /**
    * @test
    */
    public function a_admin_can_lift_a_ban_from_an_organization()
    {
        Bus::fake();
        $organizations = factory('App\Organization', 3)->create();
        $random = $organizations->random();
        $random->ban();
        $admin = factory('App\User')->create(['organization_id' => null ]);
        $admin->attachRole('admin');
        $this->actingAs($admin)
        ->post(route('admin.bans.delete'), [
            'organization_id' => $random->id,
        ])->assertSessionHasNoErrors()
        ->assertStatus(302);
        $this->assertDatabaseHas('organizations', [
            'id' => $random->id,
            'banned_at' => null 
        ]);
        Bus::assertDispatched(SendEmailToUnbannedOrganization::class); 
    }
}
