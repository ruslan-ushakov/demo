<?php

namespace Api\Model;

class ApiPaginationResponse implements \JsonSerializable
{
    /**
     * @var bool
     */
    private $success;

    /**
     * @var string|null
     */
    private $errorCode;

    /**
     * @var array
     */
    private $errorData = [];

    /**
     * @var string|null
     */
    private $userMessage;

    /**
     * @var mixed
     */
    private $result;

    /**
     * @var Pagination
     */
    private $pagination;

    public function __construct(
        $result,
        Pagination $pagination,
        ?string $userMessage = null,
        ?string $errorCode = null,
        array $errorData = []
    ) {
        $this->result = $result;
        $this->pagination = $pagination;
        $this->success = isset($errorCode) ? false : true;
        $this->userMessage = $userMessage;
        $this->errorCode = $errorCode;
        $this->errorData = $errorData;
    }

    public function jsonSerialize(): array
    {
        return [
            'metadata' => [
                'success' => $this->isSuccess(),
                'errorCode' => $this->getErrorCode(),
                'errorData' => $this->getErrorData(),
                'userMessage' => $this->getUserMessage(),
                'pagination' => $this->getPagination()
            ],
            'result' => $this->getResult()
        ];
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }


    /**
     * @return string|null
     */
    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }

    /**
     * @param string $errorCode
     *
     * @return self
     */
    public function setErrorCode(string $errorCode): self
    {
        $this->errorCode = $errorCode;

        return $this;
    }

    /**
     * @return array
     */
    public function getErrorData(): array
    {
        return $this->errorData;
    }

    /**
     * @param array $errorData
     *
     * @return self
     */
    public function setErrorData(array $errorData): self
    {
        $this->errorData = $errorData;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUserMessage(): ?string
    {
        return $this->userMessage;
    }

    /**
     * @param string $userMessage
     *
     * @return self
     */
    public function setUserMessage(string $userMessage): self
    {
        $this->userMessage = $userMessage;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     *
     * @return self
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @return Pagination
     */
    public function getPagination(): Pagination
    {
        return $this->pagination;
    }
}
