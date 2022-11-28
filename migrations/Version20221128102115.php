<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221128102115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE counters_id_seq CASCADE');
        $this->addSql('ALTER TABLE counters DROP CONSTRAINT fk_4511149188a239f4');
        $this->addSql('ALTER TABLE counters DROP CONSTRAINT fk_45111491fceef2e3');
        $this->addSql('DROP TABLE counters');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE counters_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE counters (id INT NOT NULL, is_countered_id INT NOT NULL, counter_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_45111491fceef2e3 ON counters (counter_id)');
        $this->addSql('CREATE INDEX idx_4511149188a239f4 ON counters (is_countered_id)');
        $this->addSql('ALTER TABLE counters ADD CONSTRAINT fk_4511149188a239f4 FOREIGN KEY (is_countered_id) REFERENCES heroes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE counters ADD CONSTRAINT fk_45111491fceef2e3 FOREIGN KEY (counter_id) REFERENCES heroes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
