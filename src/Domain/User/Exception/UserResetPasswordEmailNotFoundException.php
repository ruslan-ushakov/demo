<?php

namespace Domain\User\Exception;

use Domain\Base\Exception\DomainException;

class UserResetPasswordEmailNotFoundException extends DomainException
{
    public static function create(string $email)
    {
        return new self("Email {$email} not found exist");
    }
}
