<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Domain\Category;

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