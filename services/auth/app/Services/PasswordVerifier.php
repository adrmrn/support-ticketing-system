<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\HashedPassword;

interface PasswordVerifier
{
    public function isPasswordValid(string $password, HashedPassword $hashedPassword): bool;
}
