<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210622220308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE uzytkownik_dane ADD uzytkownik_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uzytkownik_dane ADD CONSTRAINT FK_3F6E2CE531D6FDE9 FOREIGN KEY (uzytkownik_id) REFERENCES uzytkownik (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3F6E2CE531D6FDE9 ON uzytkownik_dane (uzytkownik_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE uzytkownik_dane DROP FOREIGN KEY FK_3F6E2CE531D6FDE9');
        $this->addSql('DROP INDEX UNIQ_3F6E2CE531D6FDE9 ON uzytkownik_dane');
        $this->addSql('ALTER TABLE uzytkownik_dane DROP uzytkownik_id');
    }
}
