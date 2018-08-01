<?php

namespace DTO\Course;

use Domain\DateTime\Model\DateTime;

class CourseDTO
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $dateStart;

    /**
     * @var int
     */
    private $availableQuantity;

    /**
     * @var CourseTariffDTO
     */
    private $activeTariff;

    /**
     * @var CourseTariffDTO[]
     */
    private $tariffs = [];

    /**
     * @param int|null $id
     * @param string $name
     * @param \DateTime $dateStart
     * @param int $availableQuantity
     * @param CourseTariffDTO[] $tariffs
     */
    public function __construct(
        int $id,
        string $name,
        \DateTime $dateStart,
        int $availableQuantity,
        array $tariffs
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->dateStart = new DateTime($dateStart->format(DATE_ISO8601));
        $this->availableQuantity = $availableQuantity;
        $this->tariffs = $tariffs;

        foreach ($tariffs as $tariff) {
            if ($tariff->isActive()) {
                $this->activeTariff = $tariff;
                break;
            }
        }
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
     * @return \DateTime
     */
    public function getDateStart(): \DateTime
    {
        return $this->dateStart;
    }

    /**
     * @return int
     */
    public function getAvailableQuantity(): int
    {
        return $this->availableQuantity;
    }

    /**
     * @return CourseTariffDTO
     */
    public function getActiveTariff(): CourseTariffDTO
    {
        return $this->activeTariff;
    }

    /**
     * @return CourseTariffDTO[]
     */
    public function getTariffs(): array
    {
        return $this->tariffs;
    }
}
