<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220910231724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE heroes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE illustrations_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE medias_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE messages_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE profiles_pictures_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE roles_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE videos_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE heroes (id INT NOT NULL, role_id INT NOT NULL, name VARCHAR(255) NOT NULL, creation_date DATE NOT NULL, modification_date DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_578C8FC7D60322AC ON heroes (role_id)');
        $this->addSql('CREATE TABLE illustrations (id INT NOT NULL, heroes_id INT DEFAULT NULL, medias_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_830A942DAAB40E2D ON illustrations (heroes_id)');
        $this->addSql('CREATE INDEX IDX_830A942DC7F4A74B ON illustrations (medias_id)');
        $this->addSql('CREATE TABLE medias (id INT NOT NULL, heroes_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_12D2AF81AAB40E2D ON medias (heroes_id)');
        $this->addSql('CREATE TABLE messages (id INT NOT NULL, users_id INT NOT NULL, heroes_id INT NOT NULL, content TEXT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DB021E9667B3B43D ON messages (users_id)');
        $this->addSql('CREATE INDEX IDX_DB021E96AAB40E2D ON messages (heroes_id)');
        $this->addSql('CREATE TABLE profiles_pictures (id INT NOT NULL, users_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4842608567B3B43D ON profiles_pictures (users_id)');
        $this->addSql('CREATE TABLE roles (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('CREATE TABLE videos (id INT NOT NULL, heroes_id INT DEFAULT NULL, link VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_29AA6432AAB40E2D ON videos (heroes_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE heroes ADD CONSTRAINT FK_578C8FC7D60322AC FOREIGN KEY (role_id) REFERENCES roles (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE illustrations ADD CONSTRAINT FK_830A942DAAB40E2D FOREIGN KEY (heroes_id) REFERENCES heroes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE illustrations ADD CONSTRAINT FK_830A942DC7F4A74B FOREIGN KEY (medias_id) REFERENCES medias (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE medias ADD CONSTRAINT FK_12D2AF81AAB40E2D FOREIGN KEY (heroes_id) REFERENCES heroes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E9667B3B43D FOREIGN KEY (users_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96AAB40E2D FOREIGN KEY (heroes_id) REFERENCES heroes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE profiles_pictures ADD CONSTRAINT FK_4842608567B3B43D FOREIGN KEY (users_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE videos ADD CONSTRAINT FK_29AA6432AAB40E2D FOREIGN KEY (heroes_id) REFERENCES heroes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE heroes_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE illustrations_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE medias_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE messages_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE profiles_pictures_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE roles_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE videos_id_seq CASCADE');
        $this->addSql('ALTER TABLE heroes DROP CONSTRAINT FK_578C8FC7D60322AC');
        $this->addSql('ALTER TABLE illustrations DROP CONSTRAINT FK_830A942DAAB40E2D');
        $this->addSql('ALTER TABLE illustrations DROP CONSTRAINT FK_830A942DC7F4A74B');
        $this->addSql('ALTER TABLE medias DROP CONSTRAINT FK_12D2AF81AAB40E2D');
        $this->addSql('ALTER TABLE messages DROP CONSTRAINT FK_DB021E9667B3B43D');
        $this->addSql('ALTER TABLE messages DROP CONSTRAINT FK_DB021E96AAB40E2D');
        $this->addSql('ALTER TABLE profiles_pictures DROP CONSTRAINT FK_4842608567B3B43D');
        $this->addSql('ALTER TABLE videos DROP CONSTRAINT FK_29AA6432AAB40E2D');
        $this->addSql('DROP TABLE heroes');
        $this->addSql('DROP TABLE illustrations');
        $this->addSql('DROP TABLE medias');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE profiles_pictures');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE videos');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
