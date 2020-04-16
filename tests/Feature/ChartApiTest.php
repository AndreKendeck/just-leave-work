<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChartApiTest extends TestCase
{
    
         /**
         * @test
         */
    public function a_request_to_the_api_returns_an_array_of_leave_counts_grouped_by_months()
    {
        $user = factory('App\User')->create();
        $response = $this->actingAs($user)
        ->get(route('api.chart.index'))
        ->assertOk();
        $chartData = $response->decodeResponseJson(); 
        for ($i = 0 ; $i < 12 ; $i ++) {
            $this->assertTrue(array_key_exists($i, $chartData));
        }
    }
}
