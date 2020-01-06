<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200106124426 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create comments table';
    }

    public function up(Schema $schema) : void
    {
        $comments = $schema->createTable('comments');
        $comments->addColumn('id', 'uuid');
        $comments->addColumn('content', 'text');
        $comments->addColumn('author_id', 'uuid');
        $comments->addColumn('ticket_id', 'uuid');
        $comments->addColumn('created_at', 'datetime');

        $comments->setPrimaryKey(['id']);
        $comments->addIndex(['id']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('comments');
    }
}
