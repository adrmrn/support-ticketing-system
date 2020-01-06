<?php
declare(strict_types=1);

namespace User\Core\Domain;

interface HashedPassword
{
    public function __toString();
}
