<?php

namespace Domain\Course\Model;

use Doctrine\ORM\Mapping as ORM;
use Domain\Course\Model\Course;
use Domain\Course\Model\CourseTariffType;
use Domain\Course\Model\CourseType;
use Domain\Course\Model\TariffInterface;

/**
 * @ORM\Entity @ORM\Table(name="courseTariff")
 */
class CourseTariff implements TariffInterface
{
    /**
     * @var int
     * @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=16)
     */
    private $type;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true, length=32)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true, length=128)
     */
    private $description;

    /**
     * @var  int
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @var CourseType
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="courseTariffs")
     */
    private $course;

    /**
     * @param CourseTariffType $type
     * @param string $name
     * @param int $amount
     * @param Course $course
     * @param string $description
     */
    public function __construct(CourseTariffType $type, string $name, int $amount, Course $course, string $description)
    {
        $this->type = $type->getCode();
        $this->name = $name;
        $this->amount = $amount;
        $this->course = $course;
        $this->description = $description;
    }

    /**
     * @return CourseTariffType
     */
    public function getType(): CourseTariffType
    {
        return new CourseTariffType($this->type);
    }

    /**
     * @param CourseTariffType $type
     *
     * @return self
     */
    public function setType(CourseTariffType $type): self
    {
        $this->type = $type->getCode();

        return $this;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getDescription():? string
    {
        return $this->description;
    }
}
