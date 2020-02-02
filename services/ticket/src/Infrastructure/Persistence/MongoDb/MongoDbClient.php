<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Persistence\MongoDb;

use MongoDB\Client;
use MongoDB\Collection;
use MongoDB\Model\BSONDocument;

class MongoDbClient
{
    private Client $client;
    private string $database;

    public function __construct(Client $client, string $database)
    {
        $this->client = $client;
        $this->database = $database;
    }

    public function save(string $collectionName, array $data): void
    {
        $collection = $this->collection($collectionName);
        $collection->insertOne($data);
    }

    public function update(string $collectionName, array $filter, array $data): void
    {
        $collection = $this->collection($collectionName);
        $collection->updateOne($filter, ['$set' => $data]);
    }

    public function find(string $collectionName, array $filter = [], array $options = []): array
    {
        $collection = $this->collection($collectionName);
        $result = $collection->find($filter, $options);

        return array_map(
            fn(BSONDocument $item) => $item->getArrayCopy(),
            $result->toArray()
        );
    }

    private function collection(string $collectionName): Collection
    {
        return $this->client->selectCollection($this->database, $collectionName);
    }
}