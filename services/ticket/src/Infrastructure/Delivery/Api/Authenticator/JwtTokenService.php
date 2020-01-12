<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Delivery\Api\Authenticator;

use Firebase\JWT\JWT;
use Ticket\Infrastructure\Delivery\Api\Authenticator\AuthenticatedUser;
use Ticket\Domain\User\UserId;

class JwtTokenService implements TokenService
{
    private string $secret;

    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    public function isTokenValid(JwtUserToken $token): bool
    {
        try {
            JWT::decode((string)$token, $this->secret, ['HS256']);
        } catch (\Exception $exception) {
            return false;
        }

        return true;
    }

    public function decodeUserFromToken(JwtUserToken $token): AuthenticatedUser
    {
        $payload = JWT::decode((string)$token, $this->secret, ['HS256']);
        $userId = $payload->sub;
        return new AuthenticatedUser(
            UserId::fromString($userId)
        );
    }
}