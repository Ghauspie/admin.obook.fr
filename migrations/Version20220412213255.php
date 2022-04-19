<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412213255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contrat (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contrat_user (contrat_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_C0C773571823061F (contrat_id), INDEX IDX_C0C77357A76ED395 (user_id), PRIMARY KEY(contrat_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, description LONGTEXT NOT NULL, prod_link VARCHAR(255) NOT NULL, git_link VARCHAR(255) DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, is_apotheose TINYINT(1) NOT NULL, youtube_link VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spe (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, user_id INT NOT NULL, is_valid TINYINT(1) NOT NULL, INDEX IDX_C4E0A61F166D1F9C (project_id), INDEX IDX_C4E0A61FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE techno (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, logo VARCHAR(255) DEFAULT NULL, is_valid TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE techno_user (techno_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_40ED82BE51F3C1BC (techno_id), INDEX IDX_40ED82BEA76ED395 (user_id), PRIMARY KEY(techno_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, spe_id INT DEFAULT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, email VARCHAR(180) NOT NULL, story LONGTEXT DEFAULT NULL, is_search_job TINYINT(1) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649505E2510 (spe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contrat_user ADD CONSTRAINT FK_C0C773571823061F FOREIGN KEY (contrat_id) REFERENCES contrat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contrat_user ADD CONSTRAINT FK_C0C77357A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE techno_user ADD CONSTRAINT FK_40ED82BE51F3C1BC FOREIGN KEY (techno_id) REFERENCES techno (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE techno_user ADD CONSTRAINT FK_40ED82BEA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649505E2510 FOREIGN KEY (spe_id) REFERENCES spe (id)');
        $this->addSql('ALTER TABLE reset_password_request CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat_user DROP FOREIGN KEY FK_C0C773571823061F');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F166D1F9C');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649505E2510');
        $this->addSql('ALTER TABLE techno_user DROP FOREIGN KEY FK_40ED82BE51F3C1BC');
        $this->addSql('ALTER TABLE contrat_user DROP FOREIGN KEY FK_C0C77357A76ED395');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61FA76ED395');
        $this->addSql('ALTER TABLE techno_user DROP FOREIGN KEY FK_40ED82BEA76ED395');
        $this->addSql('DROP TABLE contrat');
        $this->addSql('DROP TABLE contrat_user');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE spe');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE techno');
        $this->addSql('DROP TABLE techno_user');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('ALTER TABLE reset_password_request CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
