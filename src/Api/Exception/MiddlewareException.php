<?php

namespace Api\Exception;

interface MiddlewareException
{
    public static function create(
        string $errorCode,
        string $title,
        string $description = "",
        array $additionalData = []
    ): MiddlewareException;

    public function getErrorCode(): string;

    public function getStatusCode(): int;

    public function getTitle(): string;

    public function getDescription(): string;

    public function getAdditionalData(): array;

}
