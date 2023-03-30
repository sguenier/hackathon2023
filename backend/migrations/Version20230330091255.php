<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230330091255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" ADD sex VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD birthdate TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD phonenumber VARCHAR(25) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD doctor VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD size INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD weight INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP sex');
        $this->addSql('ALTER TABLE "user" DROP birthdate');
        $this->addSql('ALTER TABLE "user" DROP phonenumber');
        $this->addSql('ALTER TABLE "user" DROP doctor');
        $this->addSql('ALTER TABLE "user" DROP size');
        $this->addSql('ALTER TABLE "user" DROP weight');
    }
}
