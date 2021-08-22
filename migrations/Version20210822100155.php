<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210822100155 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notice ADD group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notice ADD CONSTRAINT FK_480D45C2FE54D947 FOREIGN KEY (group_id) REFERENCES "sgroup" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_480D45C2FE54D947 ON notice (group_id)');
        $this->addSql('COMMENT ON COLUMN teacher.roles IS NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE notice DROP CONSTRAINT FK_480D45C2FE54D947');
        $this->addSql('DROP INDEX IDX_480D45C2FE54D947');
        $this->addSql('ALTER TABLE notice DROP group_id');
        $this->addSql('COMMENT ON COLUMN "teacher".roles IS \'(DC2Type:json_array)\'');
    }
}
