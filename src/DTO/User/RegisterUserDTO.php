<?php

namespace DTO\User;

/**
 * @SWG\Definition(
 *     definition="User.RegisterUserDTO",
 *     type="object",
 *     required={"username", "email"}
 * )
 */
class RegisterUserDTO
{
    /**
     * @var string
     *
     * @SWG\Property(example="amigo")
     */
    private $username;


    /**
     * @var string
     *
     * @SWG\Property(example="email")
     */
    private $email;

    /**
     * @var string
     *
     * @SWG\Property(example="password")
     */
    private $password;

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     */
    public function __construct(string $username, string $email, string $password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
