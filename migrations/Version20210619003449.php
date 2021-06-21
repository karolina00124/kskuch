<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210619003449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE przepisy CHANGE author_id author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE przepisy ADD CONSTRAINT FK_481CEAFFF675F31B FOREIGN KEY (author_id) REFERENCES uzytkownik (id)');
        $this->addSql('CREATE INDEX IDX_481CEAFFF675F31B ON przepisy (author_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3F6E2CE5E7927C74 ON uzytkownik_dane (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE przepisy DROP FOREIGN KEY FK_481CEAFFF675F31B');
        $this->addSql('DROP INDEX IDX_481CEAFFF675F31B ON przepisy');
        $this->addSql('ALTER TABLE przepisy CHANGE author_id author_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_3F6E2CE5E7927C74 ON uzytkownik_dane');
    }
}
