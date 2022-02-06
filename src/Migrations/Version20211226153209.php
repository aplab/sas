<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211226153209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review ADD ip_address VARCHAR(255) NOT NULL, ADD publication_datetime DATETIME DEFAULT NULL, ADD active TINYINT(1) NOT NULL');
        $this->addSql('CREATE INDEX site_list_items ON review (active, publication_datetime)');
        $this->addSql('CREATE INDEX site_list_items_with_id ON review (active, publication_datetime, id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX site_list_items ON review');
        $this->addSql('DROP INDEX site_list_items_with_id ON review');
        $this->addSql('ALTER TABLE review DROP ip_address, DROP publication_datetime, DROP active');
    }
}
