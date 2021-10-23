<?php

namespace Tests\Feature;

use App\Services\PublicHolidayApi\NagerDate;
use App\Services\PublicHolidayApi\Response\Holiday;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PublicHolidayApiTest extends TestCase
{
    use WithFaker;

    /** @test **/
    public function has_a_valid_class_structure()
    {
        $this->assertClassHasAttribute('date', Holiday::class);
        $this->assertClassHasAttribute('name', Holiday::class);
    }

    /** @test **/
    public function it_gets_all_the_public_holidays_of_a_country()
    {
        $holidays = NagerDate::getHolidays(now()->year, 'ZA');
        $this->assertIsArray($holidays);
        foreach ($holidays as $holiday) {
            $this->assertIsObject($holiday);
            $this->assertObjectHasAttribute('name', $holiday);
            $this->assertObjectHasAttribute('date', $holiday);
        }
    }
}
