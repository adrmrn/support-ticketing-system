<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Delivery\Api\Authenticator;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class JwtProvider implements AuthenticationProviderInterface
{
    private TokenService $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @inheritDoc
     */
    public function authenticate(TokenInterface $token)
    {
        /** @var JwtUserToken $token */
        if (!$this->tokenService->isTokenValid($token)) {
            throw new AuthenticationException('Unauthenticated.');
        }

        $user = $this->tokenService->decodeUserFromToken($token);
        $authenticatedJwtToken = new JwtUserToken((string)$token);
        $authenticatedJwtToken->setUser($user);
        $authenticatedJwtToken->setAuthenticated(true);
        return $authenticatedJwtToken;
    }

    /**
     * @inheritDoc
     */
    public function supports(TokenInterface $token)
    {
        return $token instanceof JwtUserToken;
    }
}