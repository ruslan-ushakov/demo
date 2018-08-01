<?php

namespace DTO\Course;

use Domain\Course\Model\CourseTariff;

class CourseTariffDTO
{

    /**
     * @var string
     */
    private $typeCode;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $price;

    /**
     * @var string
     */
    private $description;

    /**
     * @var bool
     */
    private $active;

    /**
     * @param string $typeCode
     * @param string $name
     * @param int $price
     * @param string $description
     * @param bool $active
     */
    public function __construct($typeCode, $name, $price, $description, bool $active = false)
    {
        $this->typeCode = $typeCode;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->active = $active;
    }

    public static function create(CourseTariff $courseTariff, bool $isActive = false): self
    {
        return new self(
            $courseTariff->getType()->getCode(),
            $courseTariff->getName(),
            $courseTariff->getAmount(),
            $courseTariff->getDescription(),
            $isActive
        );
    }

    /**
     * @return string
     */
    public function getTypeCode(): string
    {
        return $this->typeCode;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getPriceFormatted(): string
    {
        return number_format($this->price, 0, '.', ' ') . '₽';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }
}
