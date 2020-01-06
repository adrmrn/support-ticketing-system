<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200106120521 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create tickets table';
    }

    public function up(Schema $schema) : void
    {
        $tickets = $schema->createTable('tickets');
        $tickets->addColumn('id', 'uuid');
        $tickets->addColumn('title', 'string', ['length' => 255]);
        $tickets->addColumn('description', 'text');
        $tickets->addColumn('category_id', 'uuid');
        $tickets->addColumn('author_id', 'uuid');
        $tickets->addColumn('status', 'string', ['length' => 20]);
        $tickets->addColumn('created_at', 'datetime');

        $tickets->setPrimaryKey(['id']);
        $tickets->addIndex(['id']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('tickets');
    }
}
