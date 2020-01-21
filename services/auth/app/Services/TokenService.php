<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Credentials;
use App\Models\Token;

interface TokenService
{
    public function generateTokenBasedOnCredentials(Credentials $credentials): Token;
}
