<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Delivery\Api\Authenticator;

use Firebase\JWT\JWT;
use Ticket\Domain\User\UserRole;
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

        return new AuthenticatedUser(
            UserId::fromString($payload->sub),
            UserRole::fromString($payload->account_type)
        );
    }
}