<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221126222905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE counters DROP CONSTRAINT fk_45111491fc2deea5');
        $this->addSql('ALTER TABLE counters DROP CONSTRAINT fk_45111491900c982f');
        $this->addSql('DROP INDEX uniq_45111491900c982f');
        $this->addSql('DROP INDEX uniq_45111491fc2deea5');
        $this->addSql('ALTER TABLE counters ADD is_countered_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE counters ADD counter_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE counters DROP playing_id');
        $this->addSql('ALTER TABLE counters DROP enemy_id');
        $this->addSql('ALTER TABLE counters ADD CONSTRAINT FK_4511149188A239F4 FOREIGN KEY (is_countered_id) REFERENCES heroes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE counters ADD CONSTRAINT FK_45111491FCEEF2E3 FOREIGN KEY (counter_id) REFERENCES heroes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4511149188A239F4 ON counters (is_countered_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_45111491FCEEF2E3 ON counters (counter_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE counters DROP CONSTRAINT FK_4511149188A239F4');
        $this->addSql('ALTER TABLE counters DROP CONSTRAINT FK_45111491FCEEF2E3');
        $this->addSql('DROP INDEX UNIQ_4511149188A239F4');
        $this->addSql('DROP INDEX UNIQ_45111491FCEEF2E3');
        $this->addSql('ALTER TABLE counters ADD playing_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE counters ADD enemy_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE counters DROP is_countered_id');
        $this->addSql('ALTER TABLE counters DROP counter_id');
        $this->addSql('ALTER TABLE counters ADD CONSTRAINT fk_45111491fc2deea5 FOREIGN KEY (playing_id) REFERENCES heroes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE counters ADD CONSTRAINT fk_45111491900c982f FOREIGN KEY (enemy_id) REFERENCES heroes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_45111491900c982f ON counters (enemy_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_45111491fc2deea5 ON counters (playing_id)');
    }
}
