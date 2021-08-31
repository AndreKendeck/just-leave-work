<?php

namespace App\Services\PublicHolidayApi;

use App\Services\PublicHolidayApi\Response\Holiday;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

/**
 * This class makes requests to the NagerDate Api
 * @see https://date.nager.at/Apiƒ
 */
class NagerDate
{
    const BASE_URL = 'https://date.nager.at/api/v3/';

    const HTTP_REQUEST_CONFIG = [
        'headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]
    ];

    /**
     * Get the holiday of a specific country on a specific year
     * @param integer $year
     * @param string $countryId
     * @return array
     */
    public static function getHolidays(int $year, string $countryId): array
    {
        $guzzleClient = new Client([
            'base_uri' => self::BASE_URL,
            'headers' => self::HTTP_REQUEST_CONFIG['headers'],
            'debug' => (env('APP_ENV') === 'production' ? false : true)
        ]);

        try {
            /** @var \Psr\Http\Message\ResponseInterface $response */
            $response = $guzzleClient->get("publicholidays/{$year}/{$countryId}/");
            if ($response->getStatusCode() !== 200) {
                Log::error($response->getBody());
                return [];
            }
            return array_map(fn ($holiday) => new Holiday($holiday->date, $holiday->name), json_decode($response->getBody()));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [];
        }
    }
}
