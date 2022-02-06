<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211223155122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_form ADD dead VARCHAR(255) NOT NULL, ADD service VARCHAR(255) NOT NULL, ADD messenger VARCHAR(255) NOT NULL, ADD email TINYINT(1) NOT NULL, ADD whatsapp TINYINT(1) NOT NULL, ADD viber TINYINT(1) NOT NULL, CHANGE name client VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_form ADD name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP client, DROP dead, DROP service, DROP messenger, DROP email, DROP whatsapp, DROP viber');
    }
}
