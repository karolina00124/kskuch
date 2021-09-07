<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210907113031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE kategorie (id INT AUTO_INCREMENT NOT NULL, kategoria_nazwa VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE komentarze (id INT AUTO_INCREMENT NOT NULL, autor_id INT DEFAULT NULL, przepis_id INT DEFAULT NULL, tresc VARCHAR(255) NOT NULL, INDEX IDX_D97C0F7A14D45BBE (autor_id), INDEX IDX_D97C0F7A5002E30A (przepis_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE przepisy (id INT AUTO_INCREMENT NOT NULL, kategoria_id INT DEFAULT NULL, author_id INT DEFAULT NULL, info VARCHAR(200) NOT NULL, nazwa VARCHAR(65) NOT NULL, skladniki LONGTEXT NOT NULL, kroki LONGTEXT NOT NULL, data_utworzenia DATE NOT NULL, thumb_up INT NOT NULL, thumb_down INT NOT NULL, thumb_diff INT NOT NULL, INDEX IDX_481CEAFF359B0684 (kategoria_id), INDEX IDX_481CEAFFF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE przepisy_tagi (przepis_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_91C1E48E5002E30A (przepis_id), INDEX IDX_91C1E48EBAD26311 (tag_id), PRIMARY KEY(przepis_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tagi (id INT AUTO_INCREMENT NOT NULL, tag_nazwa VARCHAR(255) NOT NULL, data_utworzenia DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uzytkownik (id INT AUTO_INCREMENT NOT NULL, nazwa_uzytkownik VARCHAR(32) NOT NULL, haslo VARCHAR(191) NOT NULL, rola LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uzytkownik_dane (id INT AUTO_INCREMENT NOT NULL, uzytkownik_id INT DEFAULT NULL, imie VARCHAR(62) DEFAULT NULL, nazwisko VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_3F6E2CE531D6FDE9 (uzytkownik_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE komentarze ADD CONSTRAINT FK_D97C0F7A14D45BBE FOREIGN KEY (autor_id) REFERENCES uzytkownik (id)');
        $this->addSql('ALTER TABLE komentarze ADD CONSTRAINT FK_D97C0F7A5002E30A FOREIGN KEY (przepis_id) REFERENCES przepisy (id)');
        $this->addSql('ALTER TABLE przepisy ADD CONSTRAINT FK_481CEAFF359B0684 FOREIGN KEY (kategoria_id) REFERENCES kategorie (id)');
        $this->addSql('ALTER TABLE przepisy ADD CONSTRAINT FK_481CEAFFF675F31B FOREIGN KEY (author_id) REFERENCES uzytkownik (id)');
        $this->addSql('ALTER TABLE przepisy_tagi ADD CONSTRAINT FK_91C1E48E5002E30A FOREIGN KEY (przepis_id) REFERENCES przepisy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE przepisy_tagi ADD CONSTRAINT FK_91C1E48EBAD26311 FOREIGN KEY (tag_id) REFERENCES tagi (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uzytkownik_dane ADD CONSTRAINT FK_3F6E2CE531D6FDE9 FOREIGN KEY (uzytkownik_id) REFERENCES uzytkownik (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE przepisy DROP FOREIGN KEY FK_481CEAFF359B0684');
        $this->addSql('ALTER TABLE komentarze DROP FOREIGN KEY FK_D97C0F7A5002E30A');
        $this->addSql('ALTER TABLE przepisy_tagi DROP FOREIGN KEY FK_91C1E48E5002E30A');
        $this->addSql('ALTER TABLE przepisy_tagi DROP FOREIGN KEY FK_91C1E48EBAD26311');
        $this->addSql('ALTER TABLE komentarze DROP FOREIGN KEY FK_D97C0F7A14D45BBE');
        $this->addSql('ALTER TABLE przepisy DROP FOREIGN KEY FK_481CEAFFF675F31B');
        $this->addSql('ALTER TABLE uzytkownik_dane DROP FOREIGN KEY FK_3F6E2CE531D6FDE9');
        $this->addSql('DROP TABLE kategorie');
        $this->addSql('DROP TABLE komentarze');
        $this->addSql('DROP TABLE przepisy');
        $this->addSql('DROP TABLE przepisy_tagi');
        $this->addSql('DROP TABLE tagi');
        $this->addSql('DROP TABLE uzytkownik');
        $this->addSql('DROP TABLE uzytkownik_dane');
    }
}
