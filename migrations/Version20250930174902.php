<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250930174902 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE city (id SERIAL NOT NULL, country_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2D5B0234F92F3E70 ON city (country_id)');
        $this->addSql('CREATE TABLE countries (id SERIAL NOT NULL, name VARCHAR(255) DEFAULT NULL, iso_code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE cv (id SERIAL NOT NULL, teacher_id INT DEFAULT NULL, rate_per_hour DOUBLE PRECISION NOT NULL, personal_characteristics TEXT NOT NULL, experience TEXT NOT NULL, years_of_experience DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B66FFE9241807E1D ON cv (teacher_id)');
        $this->addSql('CREATE TABLE expertise (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE payment (id SERIAL NOT NULL, source_wallet_id INT NOT NULL, target_wallet_id INT NOT NULL, sum DOUBLE PRECISION NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6D28840D19BBB33D ON payment (source_wallet_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6D28840D459152DF ON payment (target_wallet_id)');
        $this->addSql('CREATE TABLE payment_types (id SERIAL NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE students (id SERIAL NOT NULL, related_user_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A4698DB298771930 ON students (related_user_id)');
        $this->addSql('CREATE TABLE studying_modes (id SERIAL NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE teacher_has_teacher_expertises (id SERIAL NOT NULL, teacher_id INT DEFAULT NULL, expertise_id INT DEFAULT NULL, rating INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AA8D1FF941807E1D ON teacher_has_teacher_expertises (teacher_id)');
        $this->addSql('CREATE INDEX IDX_AA8D1FF99D5B92F9 ON teacher_has_teacher_expertises (expertise_id)');
        $this->addSql('CREATE TABLE teachers (id SERIAL NOT NULL, related_user_id INT DEFAULT NULL, rating INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ED071FF698771930 ON teachers (related_user_id)');
        $this->addSql('CREATE TABLE teacher_studying_mode (teacher_id INT NOT NULL, studying_mode_id INT NOT NULL, PRIMARY KEY(teacher_id, studying_mode_id))');
        $this->addSql('CREATE INDEX IDX_E12F3E6541807E1D ON teacher_studying_mode (teacher_id)');
        $this->addSql('CREATE INDEX IDX_E12F3E65356AEEB9 ON teacher_studying_mode (studying_mode_id)');
        $this->addSql('CREATE TABLE teacher_payment_type (teacher_id INT NOT NULL, payment_type_id INT NOT NULL, PRIMARY KEY(teacher_id, payment_type_id))');
        $this->addSql('CREATE INDEX IDX_3B82346F41807E1D ON teacher_payment_type (teacher_id)');
        $this->addSql('CREATE INDEX IDX_3B82346FDC058279 ON teacher_payment_type (payment_type_id)');
        $this->addSql('CREATE TABLE users (id SERIAL NOT NULL, city_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL, age INT DEFAULT NULL, gender VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1483A5E98BAC62AF ON users (city_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON users (email)');
        $this->addSql('CREATE TABLE wallet (id SERIAL NOT NULL, related_user_id INT DEFAULT NULL, currency VARCHAR(255) DEFAULT NULL, cash DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7C68921F98771930 ON wallet (related_user_id)');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234F92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cv ADD CONSTRAINT FK_B66FFE9241807E1D FOREIGN KEY (teacher_id) REFERENCES teachers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D19BBB33D FOREIGN KEY (source_wallet_id) REFERENCES wallet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D459152DF FOREIGN KEY (target_wallet_id) REFERENCES wallet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE students ADD CONSTRAINT FK_A4698DB298771930 FOREIGN KEY (related_user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher_has_teacher_expertises ADD CONSTRAINT FK_AA8D1FF941807E1D FOREIGN KEY (teacher_id) REFERENCES teachers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher_has_teacher_expertises ADD CONSTRAINT FK_AA8D1FF99D5B92F9 FOREIGN KEY (expertise_id) REFERENCES expertise (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teachers ADD CONSTRAINT FK_ED071FF698771930 FOREIGN KEY (related_user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher_studying_mode ADD CONSTRAINT FK_E12F3E6541807E1D FOREIGN KEY (teacher_id) REFERENCES teachers (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher_studying_mode ADD CONSTRAINT FK_E12F3E65356AEEB9 FOREIGN KEY (studying_mode_id) REFERENCES studying_modes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher_payment_type ADD CONSTRAINT FK_3B82346F41807E1D FOREIGN KEY (teacher_id) REFERENCES teachers (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher_payment_type ADD CONSTRAINT FK_3B82346FDC058279 FOREIGN KEY (payment_type_id) REFERENCES payment_types (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E98BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT FK_7C68921F98771930 FOREIGN KEY (related_user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE city DROP CONSTRAINT FK_2D5B0234F92F3E70');
        $this->addSql('ALTER TABLE cv DROP CONSTRAINT FK_B66FFE9241807E1D');
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT FK_6D28840D19BBB33D');
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT FK_6D28840D459152DF');
        $this->addSql('ALTER TABLE students DROP CONSTRAINT FK_A4698DB298771930');
        $this->addSql('ALTER TABLE teacher_has_teacher_expertises DROP CONSTRAINT FK_AA8D1FF941807E1D');
        $this->addSql('ALTER TABLE teacher_has_teacher_expertises DROP CONSTRAINT FK_AA8D1FF99D5B92F9');
        $this->addSql('ALTER TABLE teachers DROP CONSTRAINT FK_ED071FF698771930');
        $this->addSql('ALTER TABLE teacher_studying_mode DROP CONSTRAINT FK_E12F3E6541807E1D');
        $this->addSql('ALTER TABLE teacher_studying_mode DROP CONSTRAINT FK_E12F3E65356AEEB9');
        $this->addSql('ALTER TABLE teacher_payment_type DROP CONSTRAINT FK_3B82346F41807E1D');
        $this->addSql('ALTER TABLE teacher_payment_type DROP CONSTRAINT FK_3B82346FDC058279');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT FK_1483A5E98BAC62AF');
        $this->addSql('ALTER TABLE wallet DROP CONSTRAINT FK_7C68921F98771930');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE countries');
        $this->addSql('DROP TABLE cv');
        $this->addSql('DROP TABLE expertise');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE payment_types');
        $this->addSql('DROP TABLE students');
        $this->addSql('DROP TABLE studying_modes');
        $this->addSql('DROP TABLE teacher_has_teacher_expertises');
        $this->addSql('DROP TABLE teachers');
        $this->addSql('DROP TABLE teacher_studying_mode');
        $this->addSql('DROP TABLE teacher_payment_type');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE wallet');
    }
}
