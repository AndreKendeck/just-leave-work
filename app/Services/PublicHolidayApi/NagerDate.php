<?php

namespace App\Services\PublicHolidayApi;

use App\Services\PublicHolidayApi\Response\Holiday;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * This class makes requests to the NagerDate Api
 * @see https://date.nager.at
 */
class NagerDate
{
    const HTTP_REQUEST_CONFIG = [
        'headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ],
    ];

    /**
     * Get the holiday of a specific country on a specific year
     * @param integer $year
     * @param string $countryId
     * @return array
     */
    public static function getHolidays(int $year, string $countryId): array
    {
        $http = Http::withHeaders(self::HTTP_REQUEST_CONFIG['headers']);
        $http->baseUrl(env('NAGER_DATE_API_URL'));

        try {
            /** @var \Illuminate\Http\Client\Response $response */

            $response = $http->get("publicholidays/{$year}/{$countryId}/");

            if ($response->failed()) {
                Log::error($response->json());
                return [];
            }

            return array_map(fn($holiday) => new Holiday($holiday['date'], $holiday['name']), $response->json());

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [];
        }
    }
}
