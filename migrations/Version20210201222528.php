<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210201222528 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notice DROP CONSTRAINT fk_480d45c241807e1d');
        $this->addSql('DROP INDEX idx_480d45c241807e1d');
        $this->addSql('ALTER TABLE notice RENAME COLUMN teacher_id TO teacher_id_id');
        $this->addSql('ALTER TABLE notice ADD CONSTRAINT FK_480D45C22EBB220A FOREIGN KEY (teacher_id_id) REFERENCES "teacher" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_480D45C22EBB220A ON notice (teacher_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE notice DROP CONSTRAINT FK_480D45C22EBB220A');
        $this->addSql('DROP INDEX IDX_480D45C22EBB220A');
        $this->addSql('ALTER TABLE notice RENAME COLUMN teacher_id_id TO teacher_id');
        $this->addSql('ALTER TABLE notice ADD CONSTRAINT fk_480d45c241807e1d FOREIGN KEY (teacher_id) REFERENCES teacher (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_480d45c241807e1d ON notice (teacher_id)');
    }
}
