<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210624204447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE komentarze CHANGE przepis_id przepis_id INT NOT NULL, CHANGE tresc tresc VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE przepisy CHANGE kategoria_id kategoria_id INT NOT NULL');
        $this->addSql('ALTER TABLE uzytkownik CHANGE nazwa_uzytkownik nazwa_uzytkownik VARCHAR(32) DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_3F6E2CE5E7927C74 ON uzytkownik_dane');
        $this->addSql('ALTER TABLE uzytkownik_dane CHANGE uzytkownik_id uzytkownik_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE komentarze CHANGE przepis_id przepis_id INT DEFAULT NULL, CHANGE tresc tresc VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE przepisy CHANGE kategoria_id kategoria_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uzytkownik CHANGE nazwa_uzytkownik nazwa_uzytkownik VARCHAR(32) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uzytkownik_dane CHANGE uzytkownik_id uzytkownik_id INT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3F6E2CE5E7927C74 ON uzytkownik_dane (email)');
    }
}
