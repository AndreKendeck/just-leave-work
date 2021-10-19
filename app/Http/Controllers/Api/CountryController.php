<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $guzzleClient = new Client([
            'base_uri' => env('NAGER_DATE_API_URL'),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
        try {
            /** @var \Psr\Http\Message\ResponseInterface  */
            $response = $guzzleClient->get('AvailableCountries');
            $countries = array_map(function ($country) {
                return (object) [
                    'label' => $country->name,
                    'value' => $country->countryCode,
                ];
            }, json_decode($response->getBody()));
            return response()
                ->json($countries);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'message' => $e->getMessage(),
                ], 500);
        }
    }
}
