<?php

namespace Domain\User\Service;

use Domain\User\Model\User;

interface UserServiceInterface
{
    /**
     * Регитсрирует пользоватял и сохраняет его в БД
     *
     * @param User $user
     * @param string $password
     *
     * @void
     */
    public function registerUser(User $user, string $password): void;

    /**
     * Сбрасывает пароль пользователя
     *
     * @param string $email
     * @param string $password
     * @param string $confirmationCode
     *
     * @return User
     */
    public function resetUserPassword(string $email, string $password, string $confirmationCode): User;
}
