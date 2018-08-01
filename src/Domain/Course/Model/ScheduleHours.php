<?php

namespace Domain\Course\Model;

use Domain\DateTime\Model\DayOfWeek;
use Domain\DateTime\Model\Time;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity @ORM\Table(name="scheduleHours")
 */
class ScheduleHours
{
    /**
     * @var int
     * @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
     */
    private $dayOfWeek;

    /**
     * @var \DateTime
     * @ORM\Column(type="time", nullable=false)
     */
    private $timeStart;

    /**
     * @var \DateTime
     * @ORM\Column(type="time", nullable=false)
     */
    private $timeFinish;

    /**
     * ScheduleHours constructor.
     *
     * @param \Domain\DateTime\Model\DayOfWeek $dayOfWeek
     * @param Time $timeStart
     * @param \Domain\DateTime\Model\Time $timeFinish
     */
    public function __construct(DayOfWeek $dayOfWeek, Time $timeStart, Time $timeFinish)
    {
        $this->dayOfWeek = $dayOfWeek;
        $this->timeStart = $timeStart->getDateTime();
        $this->timeFinish = $timeFinish->getDateTime();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return \Domain\DateTime\Model\DayOfWeek
     */
    public function getDayOfWeek(): DayOfWeek
    {
        return new DayOfWeek($this->dayOfWeek);
    }

    /**
     * @return Time
     */
    public function getTimeStart(): Time
    {
        return Time::createFromDateTime($this->timeStart);
    }

    /**
     * @return Time
     */
    public function getTimeFinish(): Time
    {
        return Time::createFromDateTime($this->timeFinish);
    }
}
