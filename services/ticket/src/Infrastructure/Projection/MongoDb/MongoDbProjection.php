<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Projection\MongoDb;

use Ticket\Infrastructure\Persistence\MongoDb\MongoDbClient;
use Ticket\Infrastructure\Projection\Projection;

abstract class MongoDbProjection implements Projection
{
    private MongoDbClient $client;

    public function __construct(MongoDbClient $client)
    {
        $this->client = $client;
    }

    protected function client(): MongoDbClient
    {
        return $this->client;
    }
}