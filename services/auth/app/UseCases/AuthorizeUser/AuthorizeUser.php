<?php
declare(strict_types=1);

namespace App\UseCases\AuthorizeUser;

use App\Exceptions\CredentialsNotFound;
use App\Exceptions\InvalidCredentialsProvided;
use App\Models\Email;
use App\Models\Token;
use App\Repositories\CredentialsRepository;
use App\Services\PasswordVerifier;
use App\Services\TokenService;

class AuthorizeUser
{
    private CredentialsRepository $credentialsRepository;
    private PasswordVerifier $passwordVerifier;
    private TokenService $tokenService;

    public function __construct(
        CredentialsRepository $credentialsRepository,
        PasswordVerifier $passwordVerifier,
        TokenService $tokenService
    ) {
        $this->credentialsRepository = $credentialsRepository;
        $this->passwordVerifier = $passwordVerifier;
        $this->tokenService = $tokenService;
    }

    public function execute(AuthorizeUserRequest $request): Token
    {
        $email = new Email($request->email());
        $credentials = $this->credentialsRepository->getByEmail($email);

        $isPasswordValid = $this->passwordVerifier->isPasswordValid(
            $request->password(),
            $credentials->hashedPassword()
        );
        if (!$isPasswordValid) {
            throw new InvalidCredentialsProvided();
        }

        return $this->tokenService->generateTokenForUser(
            $credentials->userId()
        );
    }
}
