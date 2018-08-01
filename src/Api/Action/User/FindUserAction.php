<?php

declare(strict_types=1);

namespace Api\Action\User;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Api\Model\ApiPaginationResponse;
use Api\Model\Listing;
use Api\Model\Pagination;
use Doctrine\ORM\EntityManagerInterface;
use Domain\User\Model\User;
use Domain\User\Repository\UserRepository;
use DTO\User\UserCriteriaDTO;
use DTO\User\UserDTO;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router;
use Swagger\Annotations as SWG;

class FindUserAction implements RequestHandlerInterface
{
    /**
     * @var Router\RouterInterface
     */
    private $router;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(
        Router\RouterInterface $router,
        EntityManagerInterface $entityManager
    ) {
        $this->router = $router;
        $this->entityManager = $entityManager;
        $this->userRepository = $this->entityManager->getRepository(User::class);
    }

    /**
     * Поиск пользователей по параметрам
     *
     * @param ServerRequestInterface $request
     *
     * @return JsonResponse
     *
     * @SWG\Get(
     *       path="/api/user/find",
     *       tags={"User"},
     *       produces={"application/json"},
     *       consumes={"application/x-www-form-urlencoded", "multipart/form-data"},
     *
     *       @SWG\Parameter(name="limit", in="query", type="integer"),
     *       @SWG\Parameter(name="offset", in="query", type="integer"),
     *       @SWG\Parameter(name="userId", in="query", type="integer"),
     *       @SWG\Parameter(name="email", in="query", type="string"),
     *       @SWG\Parameter(name="role", in="query", type="string"),
     *       @SWG\Parameter(name="username", in="query", type="string"),
     *
     *       @SWG\Response(response=200, description="Successful",
     *           @SWG\Schema(
     *              @SWG\Property(property="metadata",
     *                  @SWG\Property(property="success", type="boolean"),
     *                  @SWG\Property(property="errorCode", type="string"),
     *                  @SWG\Property(property="errorData", type="array", @SWG\Items(type="object")),
     *                  @SWG\Property(property="userMessage", type="string"),
     *                  @SWG\Property(property="pagination", ref="#/definitions/Pagination")
     *              ),
     *              @SWG\Property(property="result", type="array", @SWG\Items(ref="#/definitions/User.UserDTO"))
     *          )
     *      )
     *  )
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $params = $request->getQueryParams();
        $listing = Listing::create($request);

        $userCriteria = new UserCriteriaDTO(
            $listing->getLimit(),
            $listing->getOffset(),
            $listing->getOrderBy(),
            $params['id'] ?? null,
            $params['username'] ?? null,
            $params['email'] ?? null,
            $params['role'] ?? null
        );

        $users = $this->userRepository->findByCriteria($userCriteria);
        $userDTOs = [];
        foreach ($users as $user) {
            $userDTOs[] = UserDTO::create($user);
        }
        $pagination = new Pagination($userDTOs, $listing);

        return new JsonResponse(
            new ApiPaginationResponse($pagination->getPageItems(), $pagination)
        );
    }
}
