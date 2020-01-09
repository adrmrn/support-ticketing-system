<?php
declare(strict_types=1);

namespace App\Models;

interface HashedPassword
{
    public function __toString(): string;
}
