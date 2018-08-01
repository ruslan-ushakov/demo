<?php

namespace Domain\Course\Repository;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\ORM\EntityRepository;
use Domain\Course\Model\Course;

class CourseRepository extends EntityRepository
{
    /**
     * Находит ближайший курс заданного типа
     *
     * @return \Domain\Course\Model\Course|null
     */
    public function finNearestCourse():? Course
    {
        $criteria = (new Criteria())
            ->andWhere(new Comparison('dateStart', '>=', new \DateTime()))
            ->orderBy(['dateStart' => Criteria::ASC])
            ->setMaxResults(1);

        $persister = $this->_em->getUnitOfWork()->getEntityPersister(Course::class);
        /** @var \Domain\Course\Model\Course|null $course */
        $course = current($persister->loadCriteria($criteria));

        return $course ?: null;
    }

    /**
     * Находит последгний курса заданного типа
     *
     * @return \Domain\Course\Model\Course|null
     */
    public function findLastCourse():? Course
    {
        $criteria = (new Criteria())
            ->orderBy(['dateStart' => Criteria::DESC])
            ->setMaxResults(1);

        $persister = $this->_em->getUnitOfWork()->getEntityPersister(Course::class);
        /** @var \Domain\Course\Model\Course|null $course */
        $course = current($persister->loadCriteria($criteria));

        return $course ?: null;
    }
}
