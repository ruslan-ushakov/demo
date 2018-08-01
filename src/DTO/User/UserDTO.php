<?php

namespace DTO\User;

use Domain\User\Model\User;

/**
 * @SWG\Definition(
 *     definition="User.UserDTO",
 *     type="object",
 *     required={"id", "username", "email"}
 * )
 */
class UserDTO
{
    /**
     * @var int
     *
     * @SWG\Property(example=1)
     */
    private $id;

    /**
     * @var string
     *
     * @SWG\Property(example="amigo")
     */
    private $username;

    /**
     * @var string
     *
     * @SWG\Property(example="amigo@domain.com")
     */
    private $email;

    /**
     * @var string[]
     */
    private $roles = [];

    public function __construct(?int $id, string $username, ?string $email)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
    }

    public static function create(User $user): self
    {
        $self = new self($user->getId(), $user->getUsername(), $user->getEmail());

        $roles = [];
        foreach ($user->getRoles() as $role) {
            $roles[] = $role->getCode();
        }
        $self->roles = $roles;

        return $self;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }
}
