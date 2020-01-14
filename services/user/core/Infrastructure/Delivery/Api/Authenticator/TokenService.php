<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Delivery\Api\Authenticator;

interface TokenService
{
    public function isTokenValid(string $token): bool;

    public function decodeUserFromToken(string $token): AuthenticatedUser;
}
