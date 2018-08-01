<?php

namespace Domain\User\Model;

use Doctrine\ORM\Mapping as ORM;
use Domain\Course\Model\CoursePerson;
use Zend\Expressive\Authentication\UserInterface;

/**
 * @ORM\Entity(repositoryClass="Domain\User\Repository\UserRepository")
 * @ORM\Table(name="`user`")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface
{
    public const ROLE_GUEST = 'guest';

    /**
     * @var int
     *
     * @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=32, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=32, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $passwordEncrypted;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $confirmationCode;

    /**
     * @var CoursePerson[]
     * @ORM\OneToMany(targetEntity="Domain\Course\Model\CoursePerson", mappedBy="user")
     */
    private $coursePersons = [];

    /**
     * @var Role[]
     * @ORM\ManyToMany(targetEntity="Role", cascade={"persist"})
     */
    private $roles = [];

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @param int $id
     * @param string $username
     * @param string $email
     */
    public function __construct(?int $id = null, string $username = null, ?string $email = null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPasswordEncrypted(): string
    {
        return $this->passwordEncrypted;
    }

    public function setPasswordEncrypted(string $passwordEncrypted): self
    {
        $this->passwordEncrypted = $passwordEncrypted;

        return $this;
    }

    /**
     * @return string
     */
    public function getConfirmationCode(): string
    {
        return $this->confirmationCode;
    }

    /**
     * @param string $confirmationCode
     *
     * @return self
     */
    public function setConfirmationCode(string $confirmationCode): self
    {
        $this->confirmationCode = $confirmationCode;

        return $this;
    }

    /**
     * @return Role[]
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param Role[] $roles
     *
     * @return self
     */
    public function setRoles(array $roles): self
    {
        $this->roles = [];
        foreach ($roles as $role) {
            $this->addRole($role);
        }

        return $this;
    }

    /**
     * @param Role $role
     *
     * @return self
     */
    public function addRole(Role $role): self
    {
        $this->roles[] = $role;

        return $this;
    }

    public function getIdentity(): string
    {
        return $this->email;
    }

    public function getUserRoles(): array
    {
        $roles = [];
        foreach ($this->getRoles() as $role){
            $roles[] = $role->getCode();
        }

        return $roles;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    private function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    private function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setUpdatedAt(new \DateTime('now'));
        if ($this->createdAt === null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }
}
