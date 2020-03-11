<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PagesTest extends TestCase
{
    /**
    * @test
    */
    public function can_navigate_to_index()
    {
        $this->get(route('index'))
        ->assertOk()
        ->assertViewIs('pages.welcome');
    }

    /**
    * @test
    */
    public function navigates_to_home_when_authenticated()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user)->get(route('index'))
        ->assertViewIs('profile.home')
        ->assertViewHas('leaves');
    }

    /**
    * @test
    */
    public function can_navigate_to_about()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user)
        ->get(route('about'))
        ->assertViewIs('pages.about');
    }

    /**
    * @test
    */
    public function can_navigate_to_terms()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user)
        ->get(route('terms'))
        ->assertViewIs('pages.terms');
    }

    /**
    * @test
    */
    public function can_navigate_to_privacy()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user)
        ->get(route('privacy'))
        ->assertViewIs('pages.privacy');
    }

    /**
    * @test
    */
    public function can_navigate_to_contact()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user)
        ->get(route('contact'))
        ->assertViewIs('pages.contact');
    }

    /**
    * @test
    */
    public function can_navigate_to_settings()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user)
        ->get(route('settings'))
        ->assertViewIs('pages.settings');
    }
}
