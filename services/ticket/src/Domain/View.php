<?php
declare(strict_types=1);

namespace Ticket\Domain;

interface View
{
    public function toArray(): array;
}