<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210920102803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE additional (id BIGINT AUTO_INCREMENT NOT NULL, section_id BIGINT DEFAULT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, html_title VARCHAR(255) NOT NULL, meta_description LONGTEXT NOT NULL, meta_keywords LONGTEXT NOT NULL, price NUMERIC(20, 2) NOT NULL, text LONGTEXT NOT NULL, INDEX IDX_8BD05CE6D823E37A (section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE additional_section (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE care (id BIGINT AUTO_INCREMENT NOT NULL, section_id BIGINT DEFAULT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, html_title VARCHAR(255) NOT NULL, meta_description LONGTEXT NOT NULL, meta_keywords LONGTEXT NOT NULL, price NUMERIC(20, 2) NOT NULL, text LONGTEXT NOT NULL, INDEX IDX_6113A845D823E37A (section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE care_section (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flowers (id BIGINT AUTO_INCREMENT NOT NULL, section_id BIGINT DEFAULT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, html_title VARCHAR(255) NOT NULL, meta_description LONGTEXT NOT NULL, meta_keywords LONGTEXT NOT NULL, price NUMERIC(20, 2) NOT NULL, text LONGTEXT NOT NULL, INDEX IDX_7DAF2300D823E37A (section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flowers_section (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE additional ADD CONSTRAINT FK_8BD05CE6D823E37A FOREIGN KEY (section_id) REFERENCES additional_section (id)');
        $this->addSql('ALTER TABLE care ADD CONSTRAINT FK_6113A845D823E37A FOREIGN KEY (section_id) REFERENCES care_section (id)');
        $this->addSql('ALTER TABLE flowers ADD CONSTRAINT FK_7DAF2300D823E37A FOREIGN KEY (section_id) REFERENCES flowers_section (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE additional DROP FOREIGN KEY FK_8BD05CE6D823E37A');
        $this->addSql('ALTER TABLE care DROP FOREIGN KEY FK_6113A845D823E37A');
        $this->addSql('ALTER TABLE flowers DROP FOREIGN KEY FK_7DAF2300D823E37A');
        $this->addSql('DROP TABLE additional');
        $this->addSql('DROP TABLE additional_section');
        $this->addSql('DROP TABLE care');
        $this->addSql('DROP TABLE care_section');
        $this->addSql('DROP TABLE flowers');
        $this->addSql('DROP TABLE flowers_section');
    }
}
