<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221126225845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX uniq_45111491fceef2e3');
        $this->addSql('DROP INDEX uniq_4511149188a239f4');
        $this->addSql('ALTER TABLE counters ALTER is_countered_id SET NOT NULL');
        $this->addSql('ALTER TABLE counters ALTER counter_id SET NOT NULL');
        $this->addSql('CREATE INDEX IDX_4511149188A239F4 ON counters (is_countered_id)');
        $this->addSql('CREATE INDEX IDX_45111491FCEEF2E3 ON counters (counter_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX IDX_4511149188A239F4');
        $this->addSql('DROP INDEX IDX_45111491FCEEF2E3');
        $this->addSql('ALTER TABLE counters ALTER is_countered_id DROP NOT NULL');
        $this->addSql('ALTER TABLE counters ALTER counter_id DROP NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX uniq_45111491fceef2e3 ON counters (counter_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_4511149188a239f4 ON counters (is_countered_id)');
    }
}
