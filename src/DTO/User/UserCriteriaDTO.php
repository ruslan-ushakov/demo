<?php

namespace DTO\User;

use Doctrine\Common\Collections\Criteria;

/**
 * @SWG\Definition(
 *     definition="User.UserCriteriaDTO",
 *     type="object",
 *     required={"limit", "offset"}
 * )
 */
class UserCriteriaDTO
{
    /**
     * @var int|null
     *
     * @SWG\Property()
     */
    private $limit;

    /**
     * @var int|null
     *
     * @SWG\Property()
     */
    private $offset;

    /**
     * @var string[]
     *
     * @SWG\Property()
     */
    private $orderBy;

    /**
     * @var int|null
     *
     * @SWG\Property()
     */
    private $id;

    /**
     * @var string|null
     *
     * @SWG\Property()
     */
    private $username;

    /**
     * @var string|null
     *
     * @SWG\Property()
     */
    private $email;

    /**
     * @var string|null
     *
     * @SWG\Property()
     */
    private $role;

    /**
     * @param int|null $limit
     * @param int|null $offset
     * @param array $orderBy
     * @param int|null $id
     * @param null|string $username
     * @param null|string $email
     * @param null|string $role
     */
    public function __construct(
        ?int $limit = null,
        ?int $offset = null,
        array $orderBy = [],
        ?int $id = null,
        ?string $username = null,
        ?string $email = null,
        ?string $role = null
    ) {
        $this->assertOrderByIsCorrect($orderBy);

        $this->limit = $limit;
        $this->offset = $offset;
        $this->orderBy = $orderBy;
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->role = $role;
    }

    /**
     * @param array $orderBy
     *
     * @void
     *
     * @throws \InvalidArgumentException
     */
    private function assertOrderByIsCorrect(array $orderBy): void
    {
        $allowedOrderFields = ['id', 'username', 'email'];
        $allowedOrderDirections = [
            Criteria::ASC,
            Criteria::DESC
        ];
        foreach ($orderBy as $fieldName => $direction) {
            if (!in_array($fieldName, $allowedOrderFields)) {
                throw new \InvalidArgumentException('Ordering not allowed');
            }

            if (!in_array($direction, $allowedOrderDirections)) {
                throw new \InvalidArgumentException('Ordering direction not allowed');
            }
        }
    }

    /**
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @param int|null $limit
     *
     * @return self
     */
    public function setLimit(?int $limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * @param int|null $offset
     *
     * @return self
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getOrderBy(): array
    {
        return $this->orderBy;
    }

    /**
     * @param string[] $orderBy
     *
     * @return self
     */
    public function setOrderBy(array $orderBy)
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param null|string $username
     *
     * @return self
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * @param null|string $role
     *
     * @return self
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }
}
