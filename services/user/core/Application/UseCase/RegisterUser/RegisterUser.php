<?php
declare(strict_types=1);

namespace User\Core\Application\UseCase\RegisterUser;

use User\Core\Application\PasswordHashing;
use User\Core\Domain\User\User;
use User\Core\Domain\User\UserFullName;
use User\Core\Domain\User\UserRepository;
use User\Core\Domain\Email;

class RegisterUser
{
    private UserRepository $userRepository;
    private PasswordHashing $passwordHashing;

    public function __construct(UserRepository $userRepository, PasswordHashing $passwordHashing)
    {
        $this->userRepository = $userRepository;
        $this->passwordHashing = $passwordHashing;
    }

    public function execute(RegisterUserRequest $registerUserRequest): void
    {
        $email = new Email($registerUserRequest->email());
        if ($this->userRepository->existsByEmail($email)) {
            throw new \InvalidArgumentException('Email already exists.');
        }

        $hashedPassword = $this->passwordHashing->encrypt($registerUserRequest->password());
        $user = new User(
            $this->userRepository->nextIdentity(),
            new UserFullName(
                $registerUserRequest->firstName(),
                $registerUserRequest->lastName()
            ),
            $email,
            $hashedPassword
        );
        $this->userRepository->add($user);
    }
}
