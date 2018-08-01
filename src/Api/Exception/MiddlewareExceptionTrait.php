<?php

namespace Api\Exception;

trait MiddlewareExceptionTrait
{
    private $errorCode;
    private $statusCode;
    private $title;
    private $description;
    private $additionalData = [];

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return (string) $this->getMessage();
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getAdditionalData(): array
    {
        return $this->additionalData;
    }
}