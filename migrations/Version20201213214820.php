<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201213214820 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student DROP CONSTRAINT fk_b723af3348e1e977');
        $this->addSql('DROP INDEX idx_b723af3348e1e977');
        $this->addSql('ALTER TABLE student RENAME COLUMN address_id_id TO address_id');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B723AF33F5B7AF75 ON student (address_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE student DROP CONSTRAINT FK_B723AF33F5B7AF75');
        $this->addSql('DROP INDEX IDX_B723AF33F5B7AF75');
        $this->addSql('ALTER TABLE student RENAME COLUMN address_id TO address_id_id');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT fk_b723af3348e1e977 FOREIGN KEY (address_id_id) REFERENCES address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_b723af3348e1e977 ON student (address_id_id)');
    }
}
