<?php
declare(strict_types=1);

namespace Ticket\Shared\Domain;

interface View
{
    public function asArray(): array;
}