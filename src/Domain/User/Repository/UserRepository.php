<?php

namespace Domain\User\Repository;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use Domain\User\Model\User;
use Doctrine\Common\Collections\Expr\Comparison;
use DTO\User\UserCriteriaDTO;

class UserRepository extends EntityRepository
{
    /**
     * @param string $username
     *
     * @return User|null
     */
    public function findByUsername(string $username):? User
    {
        $criteria = (new Criteria())
            ->where(new Comparison('username', '=', $username))
            ->setMaxResults(1);

        /** @var User|null $user */
        $user = current($this->getPersister()->loadCriteria($criteria)) ?: null;

        return $user;
    }

    /**
     * @param string $email
     *
     * @return User|null
     */
    public function findByEmail(string $email):? User
    {
        $criteria = (new Criteria())
            ->where(new Comparison('email', '=', $email))
            ->setMaxResults(1);

        /** @var User|null $user */
        $user = current($this->getPersister()->loadCriteria($criteria)) ?: null;

        return $user;
    }

    /**
     * @param UserCriteriaDTO $userCriteriaDTO
     *
     * @return User[]
     */
    public function findByCriteria(UserCriteriaDTO $userCriteriaDTO): array
    {
        $criteria = new Criteria();
        if ($userCriteriaDTO->getId() !== null) {
            $criteria->andWhere(new Comparison('id', '=', $userCriteriaDTO->getId()));
        }
        if ($userCriteriaDTO->getRole() !== null) {
            $criteria->andWhere(new Comparison('role', '=', $userCriteriaDTO->getRole()));
        }
        if ($userCriteriaDTO->getEmail() !== null) {
            $criteria->andWhere(new Comparison('email', '=', $userCriteriaDTO->getEmail()));
        }
        if ($userCriteriaDTO->getUsername() !== null) {
            $criteria->andWhere(new Comparison('username', '=', $userCriteriaDTO->getUsername()));
        }
        if ($userCriteriaDTO->getLimit() !== null) {
            $criteria->setMaxResults($userCriteriaDTO->getLimit());
        }
        if ($userCriteriaDTO->getOffset() !== null) {
            $criteria->setFirstResult($userCriteriaDTO->getOffset());
        }
        if($userCriteriaDTO->getOrderBy()){
            $criteria->orderBy($userCriteriaDTO->getOrderBy());
        }

        return $this->getPersister()->loadCriteria($criteria);
    }

    private function getPersister()
    {
        return $this->_em->getUnitOfWork()->getEntityPersister(User::class);
    }
}
