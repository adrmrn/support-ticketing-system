<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Token;
use App\Models\UserId;

interface TokenService
{
    public function generateTokenForUser(UserId $userId): Token;
}
