<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\HashedPassword;

class BcryptPasswordVerifier implements PasswordVerifier
{
    public function isPasswordValid(string $password, HashedPassword $hashedPassword): bool
    {
        return password_verify($password, (string)$hashedPassword);
    }
}
