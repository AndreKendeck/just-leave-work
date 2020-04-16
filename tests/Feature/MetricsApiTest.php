<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MetricsApiTest extends TestCase
{
    /**
    * @test
    */
    public function returns_an_array_of_metrics()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user)
        ->get(route('api.metrics.index'))
        ->assertOk()
        ->assertJsonStructure(['requested' , 'approved' , 'denied' ]);
    }
}
