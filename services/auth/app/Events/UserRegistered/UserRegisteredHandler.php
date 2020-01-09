<?php
declare(strict_types=1);

namespace App\Events\UserRegistered;

use App\Events\Handler;
use App\Models\BcryptHashedPassword;
use App\Models\Credentials;
use App\Models\Email;
use App\Models\UserId;
use App\Repositories\CredentialsRepository;

class UserRegisteredHandler implements Handler
{
    private CredentialsRepository $credentialsRepository;

    public function __construct(CredentialsRepository $credentialsRepository)
    {
        $this->credentialsRepository = $credentialsRepository;
    }

    public function __invoke(UserRegisteredEvent $event)
    {
        $email = new Email($event->email());
        if ($this->credentialsRepository->doesEmailExist($email)) {
            return;
        }

        $credentials = new Credentials(
            UserId::fromString($event->userId()),
            $email,
            new BcryptHashedPassword($event->hashedPassword())
        );
        $this->credentialsRepository->store($credentials);
    }
}
