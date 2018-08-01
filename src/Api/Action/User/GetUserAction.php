<?php

declare(strict_types=1);

namespace Api\Action\User;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Domain\User\Model\User;
use DTO\User\UserDTO;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router;
use Swagger\Annotations as SWG;

class GetUserAction implements RequestHandlerInterface
{
    /**
     * @var Router\RouterInterface
     */
    private $router;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        Router\RouterInterface $router,
        EntityManagerInterface $entityManager
    ) {
        $this->router = $router;
        $this->entityManager = $entityManager;
    }

    /**
     * Получить пользователя по id
     *
     * @param ServerRequestInterface $request
     *
     * @return JsonResponse
     *
     * @SWG\Get(
     *      path="/api/user",
     *      tags={"User"},
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(name="id", in="query", required=true, type="string"),
     *
     *      @SWG\Response(response=200, description="Successful",
     *          @SWG\Schema(
     *             @SWG\Property(property="metadata",
     *                 @SWG\Property(property="success", type="boolean"),
     *                 @SWG\Property(property="errorCode", type="string"),
     *                 @SWG\Property(property="errorData", type="array", @SWG\Items(type="object")),
     *                 @SWG\Property(property="userMessage", type="string"),
     *             ),
     *             @SWG\Property(property="result", ref="#/definitions/User.UserDTO")
     *         )
     *     )
     * )
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $params = $request->getQueryParams();
        $id = (int)$params['id'];

        /** @var User|null $user */
        $user = $this->entityManager->find(User::class, $id);
        if (!$user) {
            return new JsonResponse(null, 404);
        }

        return new JsonResponse(UserDTO::create($user));
    }
}
