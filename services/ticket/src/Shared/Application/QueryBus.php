<?php
declare(strict_types=1);

namespace Ticket\Shared\Application;

use Ticket\Shared\Application\Query\Query;

interface QueryBus
{
    public function handle(Query $query);
}