<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251024210504 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE payment (id SERIAL NOT NULL, source_wallet_id INT NOT NULL, target_wallet_id INT NOT NULL, sum DOUBLE PRECISION NOT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6D28840D19BBB33D ON payment (source_wallet_id)');
        $this->addSql('CREATE INDEX IDX_6D28840D459152DF ON payment (target_wallet_id)');
        $this->addSql('COMMENT ON COLUMN payment.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN payment.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE personal_chat (id SERIAL NOT NULL, student_id INT DEFAULT NULL, teacher_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5497F597CB944F1A ON personal_chat (student_id)');
        $this->addSql('CREATE INDEX IDX_5497F59741807E1D ON personal_chat (teacher_id)');
        $this->addSql('CREATE TABLE personal_chat_message (id SERIAL NOT NULL, personal_chat_id INT DEFAULT NULL, related_user_id INT DEFAULT NULL, message TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1C06366499BD780E ON personal_chat_message (personal_chat_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1C06366498771930 ON personal_chat_message (related_user_id)');
        $this->addSql('COMMENT ON COLUMN personal_chat_message.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN personal_chat_message.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE wallet (id SERIAL NOT NULL, related_user_id INT DEFAULT NULL, currency VARCHAR(255) DEFAULT NULL, cash DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7C68921F98771930 ON wallet (related_user_id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D19BBB33D FOREIGN KEY (source_wallet_id) REFERENCES wallet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D459152DF FOREIGN KEY (target_wallet_id) REFERENCES wallet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE personal_chat ADD CONSTRAINT FK_5497F597CB944F1A FOREIGN KEY (student_id) REFERENCES students (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE personal_chat ADD CONSTRAINT FK_5497F59741807E1D FOREIGN KEY (teacher_id) REFERENCES teachers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE personal_chat_message ADD CONSTRAINT FK_1C06366499BD780E FOREIGN KEY (personal_chat_id) REFERENCES personal_chat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE personal_chat_message ADD CONSTRAINT FK_1C06366498771930 FOREIGN KEY (related_user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT FK_7C68921F98771930 FOREIGN KEY (related_user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT FK_6D28840D19BBB33D');
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT FK_6D28840D459152DF');
        $this->addSql('ALTER TABLE personal_chat DROP CONSTRAINT FK_5497F597CB944F1A');
        $this->addSql('ALTER TABLE personal_chat DROP CONSTRAINT FK_5497F59741807E1D');
        $this->addSql('ALTER TABLE personal_chat_message DROP CONSTRAINT FK_1C06366499BD780E');
        $this->addSql('ALTER TABLE personal_chat_message DROP CONSTRAINT FK_1C06366498771930');
        $this->addSql('ALTER TABLE wallet DROP CONSTRAINT FK_7C68921F98771930');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE personal_chat');
        $this->addSql('DROP TABLE personal_chat_message');
        $this->addSql('DROP TABLE wallet');
    }
}
