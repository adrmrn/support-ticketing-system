<?php
declare(strict_types=1);

namespace User\Core\Shared\Domain;

interface HashedPassword
{
    public function __toString();
}
