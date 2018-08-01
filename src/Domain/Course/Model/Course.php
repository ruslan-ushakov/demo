<?php

namespace Domain\Course\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Domain\Course\Repository\CourseRepository")
 * @ORM\Table(name="course")
 */
class Course
{
    /**
     * @var int
     * @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var CourseType
     * @ORM\ManyToOne(targetEntity="CourseType")
     */
    private $courseType;

    /**
     * @var Schedule
     * @ORM\ManyToOne(targetEntity="Schedule")
     */
    private $schedule;

    /**
     * @var Lesson[]
     * @ORM\OneToMany(targetEntity="Lesson", mappedBy="course", cascade={"persist"})
     */
    private $lessons = [];

    /**
     * @var array CoursePersons[]
     * @ORM\OneToMany(targetEntity="CoursePerson", mappedBy="course")
     */
    private $coursePersons = [];

    /**
     * @var CourseTariff[]
     * @ORM\OneToMany(targetEntity="CourseTariff", mappedBy="course")
     * @ORM\OrderBy({"amount" = "ASC"})
     */
    private $courseTariffs = [];

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime",)
     */
    private $dateStart;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $dateEnd;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return CourseType
     */
    public function getCourseType(): CourseType
    {
        return $this->courseType;
    }

    /**
     * @param CourseType $courseType
     *
     * @return self
     */
    public function setCourseType(CourseType $courseType): self
    {
        $this->courseType = $courseType;

        return $this;
    }

    /**
     * @return Schedule
     */
    public function getSchedule(): Schedule
    {
        return $this->schedule;
    }

    /**
     * @param Schedule $schedule
     *
     * @return self
     */
    public function setSchedule(Schedule $schedule): self
    {
        $this->schedule = $schedule;

        return $this;
    }


    /**
     * @return Lesson[]
     */
    public function getLessons(): array
    {
        return $this->lessons;
    }

    /**
     * @param Lesson[] $lessons
     *
     * @return self
     */
    public function setLessons(array $lessons): self
    {
        foreach ($lessons as $lesson) {
            $lesson->setCourse($this);
        }
        $this->lessons = $lessons;

        return $this;
    }

    /**
     * @return array
     */
    public function getCoursePersons(): array
    {
        return $this->coursePersons;
    }

    /**
     * @param array $coursePersons
     *
     * @return self
     */
    public function setCoursePersons(array $coursePersons): self
    {
        $this->coursePersons = $coursePersons;

        return $this;
    }

    /**
     * @return CourseTariff[]
     */
    public function getCourseTariffs()
    {
        return $this->courseTariffs;
    }

    /**
     * @param array $courseTariffs
     *
     * @return Course
     */
    public function setCourseTariffs(array $courseTariffs): self
    {
        $this->courseTariffs = $courseTariffs;

        return $this;
    }


    /**
     * @return \DateTime
     */
    public function getDateStart(): \DateTime
    {
        return $this->dateStart;
    }

    /**
     * @param \DateTime $dateStart
     *
     * @return self
     */
    public function setDateStart(\DateTime $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateEnd(): \DateTime
    {
        return $this->dateEnd;
    }

    /**
     * @param \DateTime $dateEnd
     *
     * @return self
     */
    public function setDateEnd(\DateTime $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }
}
