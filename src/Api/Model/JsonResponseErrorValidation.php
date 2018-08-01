<?php

namespace Api\Model;

use Zend\Diactoros\Response\JsonResponse;
use Zend\InputFilter\InputInterface;

class JsonResponseErrorValidation extends JsonResponse
{
    /**
     * @param InputInterface[] $data
     * @param int $status
     * @param array $headers
     * @param int $encodingOptions
     */
    public function __construct(
        array $data,
        int $status = 200,
        array $headers = [],
        int $encodingOptions = self::DEFAULT_JSON_FLAGS
    ) {
        $errors = [];
        foreach ($data as $error) {
            $errors[$error->getName()] = $error->getMessages();
        }

        parent::__construct($errors, $status, $headers, $encodingOptions);
    }
}
