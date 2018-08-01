<?php

namespace Api\Exception;

class ServerError extends \RuntimeException implements MiddlewareException
{
    use MiddlewareExceptionTrait;

    public static function create(
        string $errorCode,
        string $title,
        string $description = "",
        array $additionalData = []
    ): MiddlewareException {
        $e = new self($description, 500);
        $e->errorCode = $errorCode;
        $e->statusCode = 500;
        $e->title = $title;
        $e->additionalData = $additionalData;

        return $e;
    }
}