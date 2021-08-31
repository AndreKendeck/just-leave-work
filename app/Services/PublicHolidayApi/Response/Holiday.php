<?php

namespace App\Services\PublicHolidayApi\Response;

use \Carbon\Carbon;

/**
 * This class is a wrapper for the reesponse of the holiday 
 * arrays
 * @see https://date.nager.at/Api
 * For more information about the api
 */
class Holiday
{
    /** @var Carbon */
    protected $date;

    /** @var string */
    protected $name;

    /**
     * Generate a generic holiday class
     * @param string $date
     * @param string $name
     */
    public function __construct(string $date, string $name)
    {
        /** expected 2021-08-01 */
        $dateArray = explode('-', $date);
        $this->date = Carbon::create($dateArray[0], $dateArray[1], $dateArray[2]);
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Carbon|null
     */
    public function getDate(): ?Carbon
    {
        return $this->date;
    }
}
