<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Delivery\Api\Authenticator;

use Ticket\Infrastructure\Delivery\Api\Authenticator\AuthenticatedUser;

interface TokenService
{
    public function isTokenValid(JwtUserToken $token): bool;

    public function decodeUserFromToken(JwtUserToken $token): AuthenticatedUser;
}