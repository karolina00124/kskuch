<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210622210922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE komentarze ADD przepis_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE komentarze ADD CONSTRAINT FK_D97C0F7A5002E30A FOREIGN KEY (przepis_id) REFERENCES przepisy (id)');
        $this->addSql('CREATE INDEX IDX_D97C0F7A5002E30A ON komentarze (przepis_id)');
        $this->addSql('ALTER TABLE przepisy DROP FOREIGN KEY FK_481CEAFFD3AA5287');
        $this->addSql('DROP INDEX IDX_481CEAFFD3AA5287 ON przepisy');
        $this->addSql('ALTER TABLE przepisy DROP komentarz_id, CHANGE kategoria_id kategoria_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE komentarze DROP FOREIGN KEY FK_D97C0F7A5002E30A');
        $this->addSql('DROP INDEX IDX_D97C0F7A5002E30A ON komentarze');
        $this->addSql('ALTER TABLE komentarze DROP przepis_id');
        $this->addSql('ALTER TABLE przepisy ADD komentarz_id INT DEFAULT NULL, CHANGE kategoria_id kategoria_id INT NOT NULL');
        $this->addSql('ALTER TABLE przepisy ADD CONSTRAINT FK_481CEAFFD3AA5287 FOREIGN KEY (komentarz_id) REFERENCES komentarze (id)');
        $this->addSql('CREATE INDEX IDX_481CEAFFD3AA5287 ON przepisy (komentarz_id)');
    }
}
