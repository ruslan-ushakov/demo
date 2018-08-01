<?php

namespace Domain\Course\Model;

use Doctrine\ORM\Mapping as ORM;
use Domain\Course\Model\Course;

/**
 * @ORM\Entity @ORM\Table(name="lesson")
 */
class Lesson
{
    /**
     * @var int
     * @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="dateStart")
     */
    private $dateStart;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="dateEnd")
     */
    private $dateEnd;

    /**
     * @var Course
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="lessons")
     */
    private $course;

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

    /**
     * @return Course
     */
    public function getCourse(): Course
    {
        return $this->course;
    }

    /**
     * @param Course $course
     *
     * @return self
     */
    public function setCourse(Course $course): self
    {
        $this->course = $course;

        return $this;
    }
}