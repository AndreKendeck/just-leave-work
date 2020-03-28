<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MetricsControllerTest extends TestCase
{
    /**
    * @test
    */
    public function returns_metric_data_of_team()
    {
        $user = factory('App\User')->create(); 
        $this->actingAs($user)
        ->get(route('api.metrics.index'))
        ->assertJsonStructure(['approved' , 'denied' , 'requested' ])
        ->assertOk(); 
    }
}
