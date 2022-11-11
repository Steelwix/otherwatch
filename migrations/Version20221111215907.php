<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221111215907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE spells_icons_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE spells_icons (id INT NOT NULL, ability_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_30EE181F8016D8B2 ON spells_icons (ability_id)');
        $this->addSql('ALTER TABLE spells_icons ADD CONSTRAINT FK_30EE181F8016D8B2 FOREIGN KEY (ability_id) REFERENCES abilities (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE spells_icons_id_seq CASCADE');
        $this->addSql('ALTER TABLE spells_icons DROP CONSTRAINT FK_30EE181F8016D8B2');
        $this->addSql('DROP TABLE spells_icons');
    }
}
