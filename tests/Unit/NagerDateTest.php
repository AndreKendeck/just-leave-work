<?php

namespace Tests\Unit;

use App\Services\PublicHolidayApi\NagerDate;
use App\Services\PublicHolidayApi\Response\Holiday;
use Tests\TestCase;

class NagerDateTest extends TestCase
{
    /** @test **/
    public function it_makes_external_requests_an_returns_an_array_of_holiday_objects()
    {
        $holidays = NagerDate::getHolidays(2021, 'ZA');
        $this->assertIsArray($holidays);
        $this->assertTrue(count($holidays) > 0);
        $this->assertContainsOnlyInstancesOf(Holiday::class, $holidays);
    }

    /** @test **/
    public function it_returns_an_empty_array_when_the_wrong_request_is_sent()
    {
        $holidays = NagerDate::getHolidays(2021, 'ZAF');
        $this->assertIsArray($holidays);
        $this->assertTrue(count($holidays) === 0);
    }
}
