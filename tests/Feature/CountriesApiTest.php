<?php

namespace Tests\Feature;

use Tests\TestCase;

class CountriesApiTest extends TestCase
{
    /** @test **/
    public function it_successfully_get_countries()
    {
        $response = $this->get(route('countries'))
            ->assertOk();
        $countries = $response->json();
        foreach ($countries as $country) {
            $this->assertTrue(is_array($country));
            $this->assertArrayHasKey('value', $country);
            $this->assertArrayHasKey('label', $country);
        }
    }
}
