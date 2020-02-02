<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Domain\Category;

use MongoDB\Model\BSONDocument;
use Ticket\Domain\Category\CategoryView;
use Ticket\Domain\Category\CategoryViewRepository;
use Ticket\Infrastructure\Persistence\MongoDb\MongoDbClient;

class MongoDbCategoryViewRepository implements CategoryViewRepository
{
    private MongoDbClient $client;

    public function __construct(MongoDbClient $client)
    {
        $this->client = $client;
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        $categoriesRawData = $this->client->find('category');
        $categories = [];
        /** @var BSONDocument $categoryRawData */
        foreach ($categoriesRawData as $categoryRawData) {
            $categories[] = $this->createCategoryView($categoryRawData);
        }

        return $categories;
    }

    private function createCategoryView(array $categoryRawData): CategoryView
    {
        return new CategoryView(
            $categoryRawData['id'],
            $categoryRawData['name']
        );
    }
}