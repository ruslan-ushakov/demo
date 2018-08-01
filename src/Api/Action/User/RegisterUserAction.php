<?php

declare(strict_types=1);

namespace Api\Action\User;

use Api\Exception\InvalidRequestException;
use Api\Exception\InvalidRequestExceptionMaker;
use Api\Model\JsonResponseErrorValidation;
use Doctrine\ORM\EntityManagerInterface;
use Domain\Base\Exception\DomainException;
use Domain\User\Exception\UserRegistrationEmailExistException;
use Domain\User\Exception\UserRegistrationUsernameExistException;
use Domain\User\Model\User;
use Domain\User\Repository\UserRepository;
use Domain\User\Service\UserServiceInterface;
use DTO\User\RegisterUserDTO;
use DTO\User\UserDTO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputInterface;
use Zend\Validator;

use Swagger\Annotations as SWG;
use Zend\Hydrator\ClassMethods;

class RegisterUserAction implements RequestHandlerInterface
{
    private $router;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UserServiceInterface
     */
    private $userService;

    public function __construct(
        Router\RouterInterface $router,
        EntityManagerInterface $em,
        UserServiceInterface $userService
    ) {
        $this->router = $router;
        $this->em = $em;
        $this->userService = $userService;

        $this->userRepository = $em->getRepository(User::class);
    }

    /**
     * Добавить пользователя
     *
     * @param ServerRequestInterface $request
     *
     * @return JsonResponse
     *
     * @throws \Api\Exception\MiddlewareException
     *
     * @SWG\Post(
     *      path="/api/user/_registration",
     *      tags={"User"},
     *      produces={"application/json"},
     *      security={{"api_key": {}}},
     *
     *      @SWG\Parameter(name="user", in="body", required=true, @SWG\Schema(ref="#/definitions/User.RegisterUserDTO")),
     *
     *      @SWG\Response(response=200, description="Successful",
     *           @SWG\Schema(
     *              @SWG\Property(property="metadata",
     *                  @SWG\Property(property="success", type="boolean"),
     *                  @SWG\Property(property="errorCode", type="string"),
     *                  @SWG\Property(property="errorData", type="array", @SWG\Items(type="object")),
     *                  @SWG\Property(property="userMessage", type="string"),
     *              ),
     *              @SWG\Property(property="result",
     *                  ref="#/definitions/User.UserDTO"
     *              )
     *          )
     *      )
     *  )
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $requestDTO = $this->createRequestDTO($request);

        $user = (new User())
            ->setUsername($requestDTO->getUsername())
            ->setEmail($requestDTO->getEmail());
        $this->registerUser($user, $requestDTO->getPassword());

        return new JsonResponse(UserDTO::create($user));
    }


    /**
     * @param ServerRequestInterface $request
     *
     * @return RegisterUserDTO
     *
     * @throws \Api\Exception\MiddlewareException
     */
    private function createRequestDTO(ServerRequestInterface $request): RegisterUserDTO
    {
        $data = json_decode($request->getBody()->getContents(), true);
        $this->validateRequestData($data);

        return new RegisterUserDTO($data['username'], $data['email'], $data['password']);
    }

    /**
     * @param User $user
     * @param string $password
     *
     * @throws \Api\Exception\MiddlewareException
     */
    private function registerUser(User $user, string $password): void
    {
        try {
            $this->userService->registerUser($user, $password);
        } catch (UserRegistrationEmailExistException $e) {
            throw InvalidRequestExceptionMaker::EMAIL_EXIST($e->getMessage());

        } catch (UserRegistrationUsernameExistException $e) {
            throw InvalidRequestExceptionMaker::USERNAME_EXIST($e->getMessage());

        } catch (DomainException $e) {
            throw InvalidRequestExceptionMaker::DOMAIN_EXCEPTION($e->getMessage());
        }
    }

    /**
     * @param array $data
     *
     * @throws \Api\Exception\MiddlewareException
     */
    private function validateRequestData(array $data): void
    {
        $email = new Input('email');
        $email->getValidatorChain()
            ->attach(new Validator\EmailAddress());

        $password = new Input('password');
        $password->getValidatorChain()
            ->attach(new Validator\StringLength(['min' => 3, 'max' => 64]));

        $inputFilter = new InputFilter();
        $inputFilter->add($email);
        $inputFilter->add($password);
        $inputFilter->setData($data);

        if ($inputFilter->isValid()) {
            return;
        }

        throw InvalidRequestExceptionMaker::INVALID_REGISTRATION_DATA($inputFilter->getInvalidInput());
    }

}
