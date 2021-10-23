<?php

namespace App\Services\PublicHolidayApi\Response;

use JsonSerializable;
use \Carbon\Carbon;

/**
 * This class is a wrapper for the reesponse of the holiday
 * arrays
 * @see https://date.nager.at/Api
 * For more information about the api
 */
class Holiday implements JsonSerializable
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

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this);
    }

    /**
     * @return void
     */
    public function jsonSerialize()
    {
        return (object) [
            'name' => $this->getName(),
            'date' => $this->date->toFormattedDateString(),
        ];
    }
}
