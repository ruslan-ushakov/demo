<?php

namespace Api\Exception;

use Zend\InputFilter\Input;

class InvalidRequestException extends \RuntimeException implements MiddlewareException
{
    public const DOMAIN_EXCEPTION = 'DOMAIN_EXCEPTION';
    public const USERNAME_EXIST = 'USERNAME_EXIST';
    public const EMAIL_EXIST = 'EMAIL_EXIST';
    public const EMAIL_INCORRECT = 'EMAIL_INCORRECT';

    public const INVALID_LOGIN_OR_PASS = 'INVALID_LOGIN_OR_PASS';
    public const INVALID_REGISTRATION_DATA = 'INVALID_REGISTRATION_DATA';
    public const INVALID_REMIND_PASSWORD_DATA = 'INVALID_REMIND_PASSWORD_DATA';
    public const INVALID_RESET_PASSWORD_DATA = 'INVALID_RESET_PASSWORD_DATA';
    public const REMIND_PASSWORD_EMAIL_NOT_EXIST = 'REMIND_PASSWORD_EMAIL_NOT_EXIST';
    public const REMIND_PASSWORD_SEND_EMAIL_FAIL = 'REMIND_PASSWORD_SEND_EMAIL_FAIL';
    public const RESET_PASSWORD_INVALID_CODE = 'RESET_PASSWORD_INVALID_CODE';
    public const RESET_PASSWORD_EMAIL_NOT_FOUND = 'RESET_PASSWORD_EMAIL_NOT_FOUND';
    public const REMIND_PASSWORD_EMAIL_NOT_FOUND = 'REMIND_PASSWORD_EMAIL_NOT_FOUND';

    use MiddlewareExceptionTrait;

    public static function create(
        string $errorCode,
        string $title,
        string $description = "",
        array $additionalData = []
    ): MiddlewareException {
        $e = new self($description, 400);
        $e->statusCode = 400;
        $e->errorCode = $errorCode;
        $e->title = $title;
        $e->description = $description;
        $e->additionalData = $additionalData;

        return $e;
    }

    public static function createWithValidationErrors(
        string $errorCode,
        string $title,
        array $errors = []
    ): MiddlewareException {
        $e = new self("", 400);
        $e->statusCode = 400;
        $e->errorCode = $errorCode;
        $e->title = $title;
        $e->description = "";

        if ($errors) {
            $_data = [];
            foreach ($errors as $key => $val) {
                if ($val instanceof Input) {
                    $_data[$key] = $val->getMessages();
                } else {
                    $_data[$key] = $val;
                }
            }

            $e->additionalData = $_data;
        }

        return $e;
    }
}