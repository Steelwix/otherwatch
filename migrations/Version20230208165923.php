<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230208165923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE team_comps_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE team_comps (id INT NOT NULL, tank_id INT NOT NULL, first_damage_id INT NOT NULL, second_damage_id INT NOT NULL, first_support_id INT NOT NULL, second_support_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1ACF559615C652B5 ON team_comps (tank_id)');
        $this->addSql('CREATE INDEX IDX_1ACF559690E9B5F9 ON team_comps (first_damage_id)');
        $this->addSql('CREATE INDEX IDX_1ACF5596510FA43F ON team_comps (second_damage_id)');
        $this->addSql('CREATE INDEX IDX_1ACF5596928DD502 ON team_comps (first_support_id)');
        $this->addSql('CREATE INDEX IDX_1ACF5596E04B5496 ON team_comps (second_support_id)');
        $this->addSql('ALTER TABLE team_comps ADD CONSTRAINT FK_1ACF559615C652B5 FOREIGN KEY (tank_id) REFERENCES heroes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team_comps ADD CONSTRAINT FK_1ACF559690E9B5F9 FOREIGN KEY (first_damage_id) REFERENCES heroes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team_comps ADD CONSTRAINT FK_1ACF5596510FA43F FOREIGN KEY (second_damage_id) REFERENCES heroes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team_comps ADD CONSTRAINT FK_1ACF5596928DD502 FOREIGN KEY (first_support_id) REFERENCES heroes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team_comps ADD CONSTRAINT FK_1ACF5596E04B5496 FOREIGN KEY (second_support_id) REFERENCES heroes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE team_comps_id_seq CASCADE');
        $this->addSql('ALTER TABLE team_comps DROP CONSTRAINT FK_1ACF559615C652B5');
        $this->addSql('ALTER TABLE team_comps DROP CONSTRAINT FK_1ACF559690E9B5F9');
        $this->addSql('ALTER TABLE team_comps DROP CONSTRAINT FK_1ACF5596510FA43F');
        $this->addSql('ALTER TABLE team_comps DROP CONSTRAINT FK_1ACF5596928DD502');
        $this->addSql('ALTER TABLE team_comps DROP CONSTRAINT FK_1ACF5596E04B5496');
        $this->addSql('DROP TABLE team_comps');
    }
}
