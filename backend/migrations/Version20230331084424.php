<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230331084424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE exercice_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE exercice (id INT NOT NULL, name VARCHAR(255) NOT NULL, duration INT NOT NULL, equipment VARCHAR(255) DEFAULT NULL, description TEXT NOT NULL, urlyoutube VARCHAR(255) DEFAULT NULL, cover VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE exercice_tag (exercice_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(exercice_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_9600106489D40298 ON exercice_tag (exercice_id)');
        $this->addSql('CREATE INDEX IDX_96001064BAD26311 ON exercice_tag (tag_id)');
        $this->addSql('ALTER TABLE exercice_tag ADD CONSTRAINT FK_9600106489D40298 FOREIGN KEY (exercice_id) REFERENCES exercice (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE exercice_tag ADD CONSTRAINT FK_96001064BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE exercice_id_seq CASCADE');
        $this->addSql('ALTER TABLE exercice_tag DROP CONSTRAINT FK_9600106489D40298');
        $this->addSql('ALTER TABLE exercice_tag DROP CONSTRAINT FK_96001064BAD26311');
        $this->addSql('DROP TABLE exercice');
        $this->addSql('DROP TABLE exercice_tag');
    }
}
