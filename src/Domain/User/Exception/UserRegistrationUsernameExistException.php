<?php

namespace Domain\User\Exception;

use Domain\Base\Exception\DomainException;

class UserRegistrationUsernameExistException extends DomainException
{
    public static function create(string $username)
    {
        return new self("Username {$username} already exist");
    }
}
