<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251106221348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX uniq_1c06366498771930');
        $this->addSql('DROP INDEX uniq_1c06366499bd780e');
        $this->addSql('CREATE INDEX IDX_1C06366499BD780E ON personal_chat_message (personal_chat_id)');
        $this->addSql('CREATE INDEX IDX_1C06366498771930 ON personal_chat_message (related_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX IDX_1C06366499BD780E');
        $this->addSql('DROP INDEX IDX_1C06366498771930');
        $this->addSql('CREATE UNIQUE INDEX uniq_1c06366498771930 ON personal_chat_message (related_user_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_1c06366499bd780e ON personal_chat_message (personal_chat_id)');
    }
}
