<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210607203953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE kategorie (id INT AUTO_INCREMENT NOT NULL, kategoria_nazwa VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE przepisy (id INT AUTO_INCREMENT NOT NULL, kategoria_id INT NOT NULL, info VARCHAR(200) NOT NULL, nazwa VARCHAR(65) NOT NULL, skladniki LONGTEXT NOT NULL, kroki LONGTEXT NOT NULL, data_utworzenia DATE NOT NULL, INDEX IDX_481CEAFF359B0684 (kategoria_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE przepisy ADD CONSTRAINT FK_481CEAFF359B0684 FOREIGN KEY (kategoria_id) REFERENCES kategorie (id)');
        $this->addSql('ALTER TABLE przepisy_tagi ADD CONSTRAINT FK_91C1E48E5002E30A FOREIGN KEY (przepis_id) REFERENCES przepisy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE przepisy_tagi ADD CONSTRAINT FK_91C1E48EBAD26311 FOREIGN KEY (tag_id) REFERENCES tagi (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tagi ADD data_utworzenia DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE przepisy DROP FOREIGN KEY FK_481CEAFF359B0684');
        $this->addSql('ALTER TABLE przepisy_tagi DROP FOREIGN KEY FK_91C1E48E5002E30A');
        $this->addSql('DROP TABLE kategorie');
        $this->addSql('DROP TABLE przepisy');
        $this->addSql('ALTER TABLE przepisy_tagi DROP FOREIGN KEY FK_91C1E48EBAD26311');
        $this->addSql('ALTER TABLE tagi DROP data_utworzenia');
    }
}
