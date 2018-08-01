<?php

declare(strict_types=1);

namespace Api\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use Swagger\Annotations as SWG;

class PingAction implements RequestHandlerInterface
{
    /**
     * Пинг
     *
     * @param ServerRequestInterface $request
     *
     * @return JsonResponse
     *
     * @SWG\Get(
     *     path="/api/ping",
     *     tags={"Base"},
     *     produces={"application/json"},
     *
     *     @SWG\Response(response=200, description="Successful")
     * )
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        return new JsonResponse(['ack' => time()]);
    }
}
