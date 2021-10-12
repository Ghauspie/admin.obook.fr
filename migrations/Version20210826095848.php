<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210826095848 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apotheose DROP urlapotheose');
      
        $this->addSql('ALTER TABLE url_apotheose ADD apotheose_id INT DEFAULT NULL, DROP apotheoses');
        $this->addSql('ALTER TABLE url_apotheose ADD CONSTRAINT FK_A7F130AAB30B9D10 FOREIGN KEY (apotheose_id) REFERENCES apotheose (id)');
        $this->addSql('CREATE INDEX IDX_A7F130AAB30B9D10 ON url_apotheose (apotheose_id)');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
 
        $this->addSql('ALTER TABLE apotheose ADD urlapotheose VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
        
        $this->addSql('ALTER TABLE url_apotheose DROP FOREIGN KEY FK_A7F130AAB30B9D10');
        $this->addSql('DROP INDEX IDX_A7F130AAB30B9D10 ON url_apotheose');
        $this->addSql('ALTER TABLE url_apotheose ADD apotheoses VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, DROP apotheose_id');
           }
}
