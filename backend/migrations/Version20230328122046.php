<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230328122046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" ADD social_security_number VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD session_token VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD date_session_token TIME(0) WITHOUT TIME ZONE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP social_security_number');
        $this->addSql('ALTER TABLE "user" DROP session_token');
        $this->addSql('ALTER TABLE "user" DROP date_session_token');
    }
}
