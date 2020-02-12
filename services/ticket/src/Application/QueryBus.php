<?php
declare(strict_types=1);

namespace Ticket\Application;

use Ticket\Application\Query\Query;

interface QueryBus
{
    public function handle(Query $query);
}