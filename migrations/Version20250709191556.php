<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250709191556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE teacher_studying_mode (teacher_id INT NOT NULL, studying_mode_id INT NOT NULL, PRIMARY KEY(teacher_id, studying_mode_id))');
        $this->addSql('CREATE INDEX IDX_E12F3E6541807E1D ON teacher_studying_mode (teacher_id)');
        $this->addSql('CREATE INDEX IDX_E12F3E65356AEEB9 ON teacher_studying_mode (studying_mode_id)');
        $this->addSql('CREATE TABLE teacher_payment_type (teacher_id INT NOT NULL, payment_type_id INT NOT NULL, PRIMARY KEY(teacher_id, payment_type_id))');
        $this->addSql('CREATE INDEX IDX_3B82346F41807E1D ON teacher_payment_type (teacher_id)');
        $this->addSql('CREATE INDEX IDX_3B82346FDC058279 ON teacher_payment_type (payment_type_id)');
        $this->addSql('ALTER TABLE teacher_studying_mode ADD CONSTRAINT FK_E12F3E6541807E1D FOREIGN KEY (teacher_id) REFERENCES teachers (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher_studying_mode ADD CONSTRAINT FK_E12F3E65356AEEB9 FOREIGN KEY (studying_mode_id) REFERENCES studying_modes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher_payment_type ADD CONSTRAINT FK_3B82346F41807E1D FOREIGN KEY (teacher_id) REFERENCES teachers (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher_payment_type ADD CONSTRAINT FK_3B82346FDC058279 FOREIGN KEY (payment_type_id) REFERENCES payment_types (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher_studying_models DROP CONSTRAINT fk_987675b441807e1d');
        $this->addSql('ALTER TABLE teacher_studying_models DROP CONSTRAINT fk_987675b43c97f768');
        $this->addSql('ALTER TABLE teacher_payment_types DROP CONSTRAINT fk_c63831f641807e1d');
        $this->addSql('ALTER TABLE teacher_payment_types DROP CONSTRAINT fk_c63831f6ce74713f');
        $this->addSql('DROP TABLE teacher_studying_models');
        $this->addSql('DROP TABLE teacher_payment_types');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE teacher_studying_models (teacher_id INT NOT NULL, studying_models_id INT NOT NULL, PRIMARY KEY(teacher_id, studying_models_id))');
        $this->addSql('CREATE INDEX idx_987675b43c97f768 ON teacher_studying_models (studying_models_id)');
        $this->addSql('CREATE INDEX idx_987675b441807e1d ON teacher_studying_models (teacher_id)');
        $this->addSql('CREATE TABLE teacher_payment_types (teacher_id INT NOT NULL, payment_types_id INT NOT NULL, PRIMARY KEY(teacher_id, payment_types_id))');
        $this->addSql('CREATE INDEX idx_c63831f6ce74713f ON teacher_payment_types (payment_types_id)');
        $this->addSql('CREATE INDEX idx_c63831f641807e1d ON teacher_payment_types (teacher_id)');
        $this->addSql('ALTER TABLE teacher_studying_models ADD CONSTRAINT fk_987675b441807e1d FOREIGN KEY (teacher_id) REFERENCES teachers (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher_studying_models ADD CONSTRAINT fk_987675b43c97f768 FOREIGN KEY (studying_models_id) REFERENCES studying_modes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher_payment_types ADD CONSTRAINT fk_c63831f641807e1d FOREIGN KEY (teacher_id) REFERENCES teachers (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher_payment_types ADD CONSTRAINT fk_c63831f6ce74713f FOREIGN KEY (payment_types_id) REFERENCES payment_types (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher_studying_mode DROP CONSTRAINT FK_E12F3E6541807E1D');
        $this->addSql('ALTER TABLE teacher_studying_mode DROP CONSTRAINT FK_E12F3E65356AEEB9');
        $this->addSql('ALTER TABLE teacher_payment_type DROP CONSTRAINT FK_3B82346F41807E1D');
        $this->addSql('ALTER TABLE teacher_payment_type DROP CONSTRAINT FK_3B82346FDC058279');
        $this->addSql('DROP TABLE teacher_studying_mode');
        $this->addSql('DROP TABLE teacher_payment_type');
    }
}
