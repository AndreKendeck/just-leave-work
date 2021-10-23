<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

class CountriesApiTest extends TestCase
{
    /** @test **/
    public function it_successfully_get_countries()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents('tests/ExternalApi/countries.json'))
        ]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        $response = $client->get('/');
        $this->assertEquals(200, $response->getStatusCode());
        $countries = json_decode($response->getBody());
        foreach ($countries as $country) {
            $this->assertTrue(is_object($country));
            $this->assertObjectHasAttribute('name', $country);
            $this->assertObjectHasAttribute('countryCode', $country);
        }
    }
}
