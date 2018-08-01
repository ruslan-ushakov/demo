<?php

namespace DTO\Course;

use Domain\Course\Model\Schedule;

class ScheduleDTO
{
    /**
     * @var ScheduleDayDTO[]
     */
    private $days = [];

    /**
     * @param ScheduleDayDTO[] $days
     */
    public function __construct(array $days)
    {
        foreach ($days as $day) {
            $this->addDay($day);
        }
    }

    /**
     * @param \Domain\Course\Model\Schedule $schedule
     *
     * @return self
     */
    public static function create(Schedule $schedule)
    {
        $days = [];
        foreach ($schedule->getScheduleHours() as $scheduleHour) {
            $dayDTO = DayDTO::create($scheduleHour->getDayOfWeek());
            $days[] = new ScheduleDayDTO(
                $dayDTO,
                $scheduleHour->getTimeStart(),
                $scheduleHour->getTimeFinish()
            );
        }

        return new self($days);

    }

    /**
     * @return ScheduleDayDTO[]
     */
    public function getDays(): array
    {
        return $this->days;
    }

    /**
     * @param ScheduleDayDTO $day
     *
     * @return self
     */
    private function addDay(ScheduleDayDTO $day): self
    {
        $this->days[] = $day;

        return $this;
    }
}
