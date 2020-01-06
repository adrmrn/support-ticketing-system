<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200106110841 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create categories table';
    }

    public function up(Schema $schema) : void
    {
        $categories = $schema->createTable('categories');
        $categories->addColumn('id', 'uuid');
        $categories->addColumn('name', 'string', ['length' => 100]);

        $categories->setPrimaryKey(['id']);
        $categories->addIndex(['id']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('categories');
    }
}
