<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Token;
use App\Models\UserId;
use Firebase\JWT\JWT;

class JwtService implements TokenService
{
    private string $secret;
    private string $issuer;
    private int $expirationTimeInSeconds;

    public function __construct(string $secret, string $issuer, int $expirationTimeInMinutes)
    {
        $this->secret = $secret;
        $this->issuer = $issuer;
        $this->expirationTimeInSeconds = $expirationTimeInMinutes;
    }

    public function generateTokenForUser(UserId $userId): Token
    {
        $payload = [
            'iss' => $this->issuer, // Issuer of the token
            'sub' => (string)$userId, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60 * 60 // Expiration time
        ];

        return new Token(
            JWT::encode($payload, $this->secret)
        );
    }
}
