<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        try {
            /** $response @var \Illuminate\Http\Client\Response */
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->baseUrl(env('NAGER_DATE_API_URL'))
                ->get('AvailableCountries');

            $countries = array_map(function ($country) {
                return (object) [
                    'label' => $country['name'],
                    'value' => $country['countryCode'],
                ];
            }, $response->json());

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
