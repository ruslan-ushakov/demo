<?php

namespace DTO\Course;

class ScheduleDayDTO
{
    /**
     * @var DayDTO
     */
    private $day;

    /**
     * @var string
     */
    private $hourFrom;

    /**
     * @var string
     */
    private $hourTo;

    /**
     * @param DayDTO $day
     * @param string $hourFrom
     * @param string $hourTo
     */
    public function __construct(DayDTO $day, $hourFrom, $hourTo)
    {
        $this->day = $day;
        $this->hourFrom = $hourFrom;
        $this->hourTo = $hourTo;
    }
}
