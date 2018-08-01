<?php

namespace Domain\User\Service;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Domain\User\Exception\UserResetPasswordEmailNotFoundException;
use Domain\User\Exception\UserResetPasswordException;
use Domain\User\Exception\UserRegistrationEmailExistException;
use Domain\User\Exception\UserRegistrationException;
use Domain\User\Exception\UserRegistrationUsernameExistException;
use Domain\User\Model\User;
use Domain\User\Repository\UserRepository;

class UserService implements UserServiceInterface
{
    private const PASSWORD_MIN_LENGTH = 8;

    private const PASSWORD_MAX_LENGTH = 20;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->userRepository = $em->getRepository(User::class);
    }

    /**
     * @param User $user
     * @param string $password
     *
     * @throws UserResetPasswordException
     * @throws UserRegistrationEmailExistException
     * @throws UserRegistrationException
     * @throws UserRegistrationUsernameExistException
     */
    public function registerUser(User $user, string $password): void
    {
        $this->assertUserCredentialsIsCorrect($user);
        $this->setUserPassword($user, $password);
        $this->setConfirmationCode($user, $password);
        try {
            $this->em->persist($user);
            $this->em->flush($user);
        } catch (DBALException | ORMException | OptimisticLockException $e) {
            throw new UserRegistrationException("Error while adding a user", 0, $e);
        }
    }

    /**
     * @param string $email
     * @param string $password
     * @param string $confirmationCode
     *
     * @return User
     *
     * @throws UserResetPasswordException
     * @throws UserResetPasswordEmailNotFoundException
     */
    public function resetUserPassword(string $email, string $password, string $confirmationCode): User
    {
        $user = $this->getUserByEmail($email);
        if ($user->getConfirmationCode() !== $confirmationCode) {
            throw new UserResetPasswordException("Confirmation code  {$confirmationCode} is invalid");
        }

        $this->setUserPassword($user, $password);
        $this->setConfirmationCode($user, $password);
        try {
            $this->em->persist($user);
            $this->em->flush($user);
        } catch (DBALException | ORMException | OptimisticLockException $e) {
            throw new UserRegistrationException("Error while adding a user", 0, $e);
        }

        return $user;
    }

    /**
     * @param User $user
     * @param string $password
     *
     * @throws UserResetPasswordException
     */
    private function setUserPassword(User $user, string $password): void
    {
        $this->assertPasswordIsCorrect($password);
        $user->setPasswordEncrypted(
            $this->hashPassword($password)
        );
    }

    private function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @param User $user
     * @param string $password
     */
    private function setConfirmationCode(User $user, string $password): void
    {
        $user->setConfirmationCode(password_hash($user->getEmail() . $password, PASSWORD_BCRYPT));
    }

    /**
     * @param string $password
     *
     * @throws UserResetPasswordException
     */
    private function assertPasswordIsCorrect(string $password): void
    {
        $minLength = self::PASSWORD_MIN_LENGTH;
        $maxLength = self::PASSWORD_MAX_LENGTH;
        $passwordLength = strlen($password);

        if (!($minLength <= $passwordLength && $passwordLength <= $maxLength)) {
            throw new UserResetPasswordException(
                "The password must be between {$minLength} and {$maxLength} characters long (inclusive)" . PHP_EOL .
                "Received length: {$passwordLength}"
            );
        }
    }

    /**
     * @param User $user
     *
     * @throws UserRegistrationEmailExistException
     * @throws UserRegistrationUsernameExistException
     */
    private function assertUserCredentialsIsCorrect(User $user): void
    {
        $found = $this->userRepository->findByUsername($user->getUsername());
        if ($found) {
            throw UserRegistrationUsernameExistException::create($user->getUsername());
        }

        $found = $this->userRepository->findByEmail($user->getEmail());
        if ($found) {
            throw UserRegistrationEmailExistException::create($user->getEmail());
        }
    }

    /**
     * @param string $email
     *
     * @return User
     */
    private function getUserByEmail($email): User
    {
        $user = $this->userRepository->findByEmail($email);
        if (!$user) {
            throw UserResetPasswordEmailNotFoundException::create($email);
        }

        return $user;
    }
}
