<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251003182239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE personal_chat_messages_id_seq CASCADE');
        $this->addSql('CREATE TABLE personal_chat_message (id SERIAL NOT NULL, personal_chat_id INT DEFAULT NULL, related_user_id INT DEFAULT NULL, message TEXT NOT NULL, "order" INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1C06366499BD780E ON personal_chat_message (personal_chat_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1C06366498771930 ON personal_chat_message (related_user_id)');
        $this->addSql('COMMENT ON COLUMN personal_chat_message.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN personal_chat_message.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE personal_chat_message ADD CONSTRAINT FK_1C06366499BD780E FOREIGN KEY (personal_chat_id) REFERENCES personal_chat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE personal_chat_message ADD CONSTRAINT FK_1C06366498771930 FOREIGN KEY (related_user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE personal_chat_messages DROP CONSTRAINT fk_51cd6c7c99bd780e');
        $this->addSql('ALTER TABLE personal_chat_messages DROP CONSTRAINT fk_51cd6c7c98771930');
        $this->addSql('DROP TABLE personal_chat_messages');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE personal_chat_messages_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE personal_chat_messages (id SERIAL NOT NULL, personal_chat_id INT DEFAULT NULL, related_user_id INT DEFAULT NULL, "order" INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, message TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_51cd6c7c98771930 ON personal_chat_messages (related_user_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_51cd6c7c99bd780e ON personal_chat_messages (personal_chat_id)');
        $this->addSql('COMMENT ON COLUMN personal_chat_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN personal_chat_messages.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE personal_chat_messages ADD CONSTRAINT fk_51cd6c7c99bd780e FOREIGN KEY (personal_chat_id) REFERENCES personal_chat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE personal_chat_messages ADD CONSTRAINT fk_51cd6c7c98771930 FOREIGN KEY (related_user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE personal_chat_message DROP CONSTRAINT FK_1C06366499BD780E');
        $this->addSql('ALTER TABLE personal_chat_message DROP CONSTRAINT FK_1C06366498771930');
        $this->addSql('DROP TABLE personal_chat_message');
    }
}
