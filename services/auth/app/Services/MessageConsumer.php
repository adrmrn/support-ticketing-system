<?php
declare(strict_types=1);

namespace App\Services;

interface MessageConsumer
{
    public function open(string $exchangeName): void;

    public function consume(string $exchangeName, callable $handler): void;

    public function close(): void;
}
