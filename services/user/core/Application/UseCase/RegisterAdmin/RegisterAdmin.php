<?php
declare(strict_types=1);

namespace User\Core\Application\UseCase\RegisterAdmin;

use User\Core\Application\PasswordHashing;
use User\Core\Domain\Email;
use User\Core\Domain\User\User;
use User\Core\Domain\User\UserFullName;
use User\Core\Domain\User\UserRepository;
use User\Core\Domain\User\UserRole;

class RegisterAdmin
{
    private UserRepository $userRepository;
    private PasswordHashing $passwordHashing;

    public function __construct(UserRepository $userRepository, PasswordHashing $passwordHashing)
    {
        $this->userRepository = $userRepository;
        $this->passwordHashing = $passwordHashing;
    }

    public function execute(RegisterAdminRequest $registerAdminRequest): void
    {
        $email = new Email($registerAdminRequest->email());
        if ($this->userRepository->existsByEmail($email)) {
            throw new \InvalidArgumentException('Email already exists.');
        }

        $hashedPassword = $this->passwordHashing->encrypt($registerAdminRequest->password());
        $user = new User(
            $this->userRepository->nextIdentity(),
            new UserFullName(
                $registerAdminRequest->firstName(),
                $registerAdminRequest->lastName()
            ),
            $email,
            $hashedPassword,
            UserRole::admin()
        );
        $this->userRepository->add($user);
    }
}
