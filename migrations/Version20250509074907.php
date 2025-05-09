<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250509074907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE library ADD COLUMN bildnamn VARCHAR(255) NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__library AS SELECT id, titel, isbn, forfattare, bild FROM library
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE library
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE library (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titel VARCHAR(255) NOT NULL, isbn INTEGER NOT NULL, forfattare VARCHAR(255) DEFAULT NULL, bild VARCHAR(255) DEFAULT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO library (id, titel, isbn, forfattare, bild) SELECT id, titel, isbn, forfattare, bild FROM __temp__library
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__library
        SQL);
    }
}
