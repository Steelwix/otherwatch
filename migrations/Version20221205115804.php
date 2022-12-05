<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221205115804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE heroes_synergy (heroes_source INT NOT NULL, heroes_target INT NOT NULL, PRIMARY KEY(heroes_source, heroes_target))');
        $this->addSql('CREATE INDEX IDX_8B1FFD2A6229F570 ON heroes_synergy (heroes_source)');
        $this->addSql('CREATE INDEX IDX_8B1FFD2A7BCCA5FF ON heroes_synergy (heroes_target)');
        $this->addSql('ALTER TABLE heroes_synergy ADD CONSTRAINT FK_8B1FFD2A6229F570 FOREIGN KEY (heroes_source) REFERENCES heroes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE heroes_synergy ADD CONSTRAINT FK_8B1FFD2A7BCCA5FF FOREIGN KEY (heroes_target) REFERENCES heroes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE heroes_synergy DROP CONSTRAINT FK_8B1FFD2A6229F570');
        $this->addSql('ALTER TABLE heroes_synergy DROP CONSTRAINT FK_8B1FFD2A7BCCA5FF');
        $this->addSql('DROP TABLE heroes_synergy');
    }
}
