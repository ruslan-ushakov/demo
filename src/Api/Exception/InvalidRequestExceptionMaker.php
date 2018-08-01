<?php

namespace Api\Exception;

class InvalidRequestExceptionMaker
{
    public static function DOMAIN_EXCEPTION(string $description, string $title = "Domain exception")
    {
        return InvalidRequestException::create(InvalidRequestException::DOMAIN_EXCEPTION, $title, $description);
    }

    public static function USERNAME_EXIST(string $description, string $title = "Username exist")
    {
        return InvalidRequestException::create(InvalidRequestException::USERNAME_EXIST, $title, $description);
    }

    public static function EMAIL_EXIST(string $description, string $title = "Email exist")
    {
        return InvalidRequestException::create(InvalidRequestException::EMAIL_EXIST, $title, $description);
    }

    public static function EMAIL_INCORRECT(array $errors, string $title = "Email incorrect")
    {
        return InvalidRequestException::create(InvalidRequestException::EMAIL_INCORRECT, $title, $title, $errors);
    }

    public static function INVALID_REGISTRATION_DATA(array $errors, string $title = "Invalid registration data")
    {
        return InvalidRequestException::create(InvalidRequestException::INVALID_REGISTRATION_DATA, $title, $title,
            $errors);
    }

    public static function INVALID_RESET_PASSWORD_DATA(array $errors, string $title = "Invalid reset password data")
    {
        return InvalidRequestException::create(InvalidRequestException::INVALID_RESET_PASSWORD_DATA, $title, $title,
            $errors);
    }

    public static function REMIND_PASSWORD_EMAIL_NOT_FOUND(string $description, string $title = "Email not exist")
    {
        return InvalidRequestException::create(InvalidRequestException::REMIND_PASSWORD_EMAIL_NOT_FOUND, $title,
            $description);
    }

    public static function REMIND_PASSWORD_SEND_EMAIL_FAIL(string $description, string $title = "Send email fail")
    {
        return InvalidRequestException::create(InvalidRequestException::REMIND_PASSWORD_SEND_EMAIL_FAIL, $title,
            $description);
    }

    public static function RESET_PASSWORD_EMAIL_NOT_FOUND(string $description, string $title = "Email not exist")
    {
        return InvalidRequestException::create(InvalidRequestException::RESET_PASSWORD_EMAIL_NOT_FOUND, $title,
            $description);
    }

    public static function RESET_PASSWORD_INVALID_CODE(
        string $description,
        string $title = "Confirmation code is invalid"
    ) {
        return InvalidRequestException::create(InvalidRequestException::RESET_PASSWORD_INVALID_CODE, $title,
            $description);
    }
}
