<?php

namespace Domain\Course\Model;

use Doctrine\ORM\Mapping as ORM;
use Domain\Course\Model\ScheduleHours;

/**
 * @ORM\Entity @ORM\Table(name="schedule")
 */
class Schedule
{
    /**
     * @var int
     * @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var ScheduleHours[]
     * @ORM\ManyToMany(targetEntity="ScheduleHours", cascade={"persist"})
     */
    private $scheduleHours = [];

    /**
     * Schedule constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return ScheduleHours[]
     */
    public function getScheduleHours()
    {
        return $this->scheduleHours;
    }

    /**
     * @param ScheduleHours[] $scheduleHours
     *
     * @return self
     */
    public function setScheduleHours(array $scheduleHours): self
    {
        foreach ($scheduleHours as $hours) {
            $this->addScheduleHours($hours);
        }

        return $this;
    }

    /**
     * @param ScheduleHours $scheduleHours
     *
     * @return self
     */
    public function addScheduleHours(ScheduleHours $scheduleHours): self
    {
        $this->scheduleHours[] = $scheduleHours;

        return $this;
    }
}
