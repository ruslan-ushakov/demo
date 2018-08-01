<?php

namespace Domain\Course\Model;

use Domain\Course\Model\Course;
use Domain\Course\Model\CourseTariff;
use Domain\Course\Model\CourseType;
use DTO\Course\PersonDTO;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity @ORM\Table(name="eventBooking")
 */
class EventBooking
{
    /**
     * @var int|null
     * @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $personName;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $personLastName;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $personEmail;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $personPhone;

    /**
     * @var CourseType
     * @ORM\ManyToOne(targetEntity="Course")
     */
    private $course;

    /**
     * @var CourseTariff
     * @ORM\ManyToOne(targetEntity="CourseTariff")
     */
    private $courseTariff;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true, length=512)
     */
    private $comment;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @param \DTO\Course\PersonDTO $person
     * @param Course
     * @param CourseTariff $courseTariff
     * @param string|null $comment
     */
    public function __construct(PersonDTO $person, Course $course, CourseTariff $courseTariff, ?string $comment = null)
    {
        $this->setPerson($person);
        $this->course = $course;
        $this->courseTariff = $courseTariff;
        $this->comment = $comment;
        $this->createdAt = new \DateTime();
    }

    /**
     * @return int|null
     */
    public function getId():? int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     *
     * @return self
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return \DTO\Course\PersonDTO
     */
    public function getPerson(): PersonDTO
    {
        return new PersonDTO(
            $this->personName,
            $this->personLastName,
            $this->personEmail,
            $this->personPhone
        );
    }

    /**
     * @param \DTO\Course\PersonDTO $person
     *
     * @return self
     */
    public function setPerson(PersonDTO $person): self
    {
        $this->personName = $person->getName();
        $this->personLastName = $person->getLastName();
        $this->personEmail = $person->getEmail();
        $this->personPhone = $person->getPhone();

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

    /**
     * @return CourseTariff
     */
    public function getCourseTariff(): CourseTariff
    {
        return $this->courseTariff;
    }

    /**
     * @param CourseTariff $courseTariff
     *
     * @return self
     */
    public function setCourseTariff(CourseTariff $courseTariff): self
    {
        $this->courseTariff = $courseTariff;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param null|string $comment
     *
     * @return self
     */
    public function setComment($comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
}
