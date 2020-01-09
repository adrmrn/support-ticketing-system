<?php
declare(strict_types=1);

namespace App\Models;

class Token
{
    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function __toString(): string
    {
        return $this->token;
    }
}
