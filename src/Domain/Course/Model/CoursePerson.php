<?php

namespace Domain\Course\Model;

use Doctrine\ORM\Mapping as ORM;
use Domain\User\Model\User;

/**
 * @ORM\Entity @ORM\Table(name="coursePerson")
 */
class CoursePerson
{
    /**
     * @var int
     * @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $lastName;

    /**
     * @var Course
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="coursePersons")
     */
    private $course;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="Domain\User\Model\User", inversedBy="coursePersons")
     */
    private $user;

    /**
     * @param string $firstName
     * @param string $lastName
     * @param Course $course
     * @param User $user
     */
    public function __construct(
        Course $course,
        $firstName = null,
        $lastName = null,
        $user = null
    ){
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->course = $course;
        $this->user = $user;
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
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return Course
     */
    public function getCourse(): Course
    {
        return $this->course;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
