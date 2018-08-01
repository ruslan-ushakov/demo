<?php

namespace Domain\Course\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Domain\Course\Model\CourseTariff;
use Domain\Course\Model\CourseTariffType;

class CourseTariffService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param CourseTariff[] $courseTariffs
     * @param \DateTime $courseDateStart
     *
     * @return CourseTariff|null
     */
    public function findActualTariff($courseTariffs, \DateTime $courseDateStart):? CourseTariff
    {
        $currentDateTime = new \DateTime();

        $interval = $currentDateTime->diff($courseDateStart);
        $daysBeforeStart = $interval->days;

        $courseTariffsByType = [];
        foreach ($courseTariffs as $courseTariff) {
            $courseTariffsByType[$courseTariff->getType()->getCode()] = $courseTariff;
        }

        switch (true) {
            case $daysBeforeStart > 7:
                $actualTariff = $courseTariffsByType[CourseTariffType::CODE_EARLY];
                break;

            case $daysBeforeStart > 1:
                $actualTariff = $courseTariffsByType[CourseTariffType::CODE_REGULAR];
                break;

            case $daysBeforeStart >= 0:
                $actualTariff = $courseTariffsByType[CourseTariffType::CODE_LAST_CHANCE];
                break;

            default:
                $actualTariff = null;
        }

        return $actualTariff;
    }
}
