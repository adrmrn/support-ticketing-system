<?php
declare(strict_types=1);

namespace Ticket\Shared\Domain;

interface View
{
    public function toArray(): array;
}