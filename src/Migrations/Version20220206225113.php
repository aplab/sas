<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220206225113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE additional (id BIGINT AUTO_INCREMENT NOT NULL, section_id BIGINT DEFAULT NULL, name VARCHAR(255) NOT NULL, additional VARCHAR(255) NOT NULL, html_title VARCHAR(255) NOT NULL, meta_description LONGTEXT NOT NULL, meta_keywords LONGTEXT NOT NULL, price_string VARCHAR(255) NOT NULL, sort_order BIGINT NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_modified DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, INDEX IDX_8BD05CE6D823E37A (section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE additional_section (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, sort_order BIGINT NOT NULL, active TINYINT(1) NOT NULL, extract TINYINT(1) NOT NULL, text LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE adjacency_list (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, sort_order BIGINT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_modified DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, INDEX parent_id (parent_id), INDEX sort_order (sort_order), INDEX order_id (sort_order, id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_880E0D76F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bind_contained (id BIGINT AUTO_INCREMENT NOT NULL, container_id BIGINT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_89602878BC21F742 (container_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bind_container (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE burial (id BIGINT AUTO_INCREMENT NOT NULL, city_id BIGINT DEFAULT NULL, cemetery_id BIGINT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, middle_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, obituary LONGTEXT NOT NULL, birth_date DATE DEFAULT NULL, birth_year SMALLINT NOT NULL, death_date DATE DEFAULT NULL, death_year SMALLINT NOT NULL, age SMALLINT NOT NULL, burial_type_name VARCHAR(255) NOT NULL, section_name VARCHAR(255) NOT NULL, alley_name VARCHAR(255) NOT NULL, cemetery_name VARCHAR(255) NOT NULL, latitude NUMERIC(15, 12) DEFAULT \'0\' NOT NULL, longitude NUMERIC(15, 12) DEFAULT \'0\' NOT NULL, photo_path1 VARCHAR(255) NOT NULL, photo_path2 VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_modified DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, INDEX last_name (last_name(40)), INDEX first_name (first_name(40)), INDEX middle_name (middle_name(40)), INDEX cemetery_name (cemetery_name(40)), INDEX city_id (city_id), INDEX cemetery_id (cemetery_id), INDEX names (last_name(40), first_name(40), middle_name(40)), INDEX names_cemetery (last_name(40), first_name(40), middle_name(40), cemetery_name(40)), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE care (id BIGINT AUTO_INCREMENT NOT NULL, section_id BIGINT DEFAULT NULL, name VARCHAR(255) NOT NULL, additional VARCHAR(255) NOT NULL, popular TINYINT(1) NOT NULL, html_title VARCHAR(255) NOT NULL, meta_description LONGTEXT NOT NULL, meta_keywords LONGTEXT NOT NULL, price_string VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, sort_order BIGINT NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_modified DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, INDEX IDX_6113A845D823E37A (section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE care_section (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, sort_order BIGINT NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cemetery (id BIGINT AUTO_INCREMENT NOT NULL, city_id BIGINT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cemetery_section (id BIGINT AUTO_INCREMENT NOT NULL, cemetery_id BIGINT DEFAULT NULL, name VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, label_tmp VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, name_en VARCHAR(255) NOT NULL, latitude NUMERIC(10, 6) DEFAULT \'0\' NOT NULL, longitude NUMERIC(10, 6) DEFAULT \'0\' NOT NULL, active TINYINT(1) NOT NULL, is_default TINYINT(1) NOT NULL, okato CHAR(20) DEFAULT \'\' NOT NULL, subdomain VARCHAR(120) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, publication_datetime DATETIME DEFAULT NULL, comment LONGTEXT NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_modified DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, user_agent VARCHAR(255) NOT NULL, ip_address VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, object_type VARCHAR(255) NOT NULL, object_id BIGINT NOT NULL, user_id BIGINT NOT NULL, parent_id BIGINT NOT NULL, INDEX parent_id (parent_id), INDEX object_typeid (object_type, object_id), INDEX object_typeid_crtd (object_type, object_id, created_at), INDEX object_idtype (object_id, object_type), INDEX active (active), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feedback_form (id BIGINT AUTO_INCREMENT NOT NULL, client VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_modified DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fields_example (id BIGINT AUTO_INCREMENT NOT NULL, flag TINYINT(1) NOT NULL, textarea VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, image2 VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_modified DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, name VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id BIGINT AUTO_INCREMENT NOT NULL, filename VARCHAR(255) NOT NULL, module VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, latitude NUMERIC(15, 12) DEFAULT \'0\' NOT NULL, longitude NUMERIC(15, 12) DEFAULT \'0\' NOT NULL, burial_id BIGINT NOT NULL, user_id BIGINT NOT NULL, created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flowers (id BIGINT AUTO_INCREMENT NOT NULL, section_id BIGINT DEFAULT NULL, name VARCHAR(255) NOT NULL, additional VARCHAR(255) NOT NULL, article VARCHAR(255) NOT NULL, size VARCHAR(255) NOT NULL, image1 VARCHAR(255) NOT NULL, thumbnail1 VARCHAR(255) NOT NULL, image2 VARCHAR(255) NOT NULL, thumbnail2 VARCHAR(255) NOT NULL, image3 VARCHAR(255) NOT NULL, thumbnail3 VARCHAR(255) NOT NULL, image4 VARCHAR(255) NOT NULL, thumbnail4 VARCHAR(255) NOT NULL, html_title VARCHAR(255) NOT NULL, meta_description LONGTEXT NOT NULL, meta_keywords LONGTEXT NOT NULL, price_string VARCHAR(255) NOT NULL, sort_order BIGINT NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_modified DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, more_images TINYINT(1) NOT NULL, INDEX IDX_7DAF2300D823E37A (section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flowers_section (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, sort_order BIGINT NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE history_upload_image (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, thumbnail VARCHAR(255) NOT NULL, comment LONGTEXT NOT NULL, width INT UNSIGNED NOT NULL, height INT UNSIGNED NOT NULL, favorites TINYINT(1) DEFAULT \'0\' NOT NULL, created_at DATETIME NULL DEFAULT CURRENT_TIMESTAMP, INDEX path (path), INDEX favorites (favorites), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE interesting (id BIGINT AUTO_INCREMENT NOT NULL, section_id BIGINT DEFAULT NULL, name VARCHAR(255) NOT NULL, publication_datetime DATETIME DEFAULT NULL, image1 VARCHAR(255) NOT NULL, image2 VARCHAR(255) NOT NULL, text1 LONGTEXT NOT NULL, text2 LONGTEXT NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_modified DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, html_title VARCHAR(255) NOT NULL, meta_description LONGTEXT NOT NULL, meta_keywords LONGTEXT NOT NULL, source VARCHAR(255) NOT NULL, source_url VARCHAR(255) NOT NULL, INDEX IDX_AC3BA1D6D823E37A (section_id), INDEX publication_datetime (publication_datetime), INDEX active_section_pubdatetime (active, section_id, publication_datetime), INDEX active (active), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE my_sample_entity (id BIGINT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE named_timestampable (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_modified DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, publication_datetime DATETIME DEFAULT NULL, image1 VARCHAR(255) NOT NULL, image2 VARCHAR(255) NOT NULL, text1 LONGTEXT NOT NULL, text2 LONGTEXT NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_modified DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, html_title VARCHAR(255) NOT NULL, meta_description LONGTEXT NOT NULL, meta_keywords LONGTEXT NOT NULL, source VARCHAR(255) NOT NULL, source_url VARCHAR(255) NOT NULL, INDEX actual (active, publication_datetime), INDEX publication_datetime (publication_datetime), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE obituary_form (id BIGINT AUTO_INCREMENT NOT NULL, dead VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, obituary LONGTEXT NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_modified DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_form (id BIGINT AUTO_INCREMENT NOT NULL, client VARCHAR(255) NOT NULL, dead VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, service VARCHAR(255) NOT NULL, messenger VARCHAR(255) NOT NULL, email TINYINT(1) NOT NULL, whatsapp TINYINT(1) NOT NULL, viber TINYINT(1) NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_modified DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_passport (id BIGINT AUTO_INCREMENT NOT NULL, cemetery_id BIGINT DEFAULT NULL, client VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, dead VARCHAR(255) NOT NULL, obituary TINYINT(1) NOT NULL, photo TINYINT(1) NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_modified DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organization (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parameter (id BIGINT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, textarea VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, INDEX code (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, publication_datetime DATETIME DEFAULT NULL, image1 VARCHAR(255) NOT NULL, image2 VARCHAR(255) NOT NULL, text1 LONGTEXT NOT NULL, text2 LONGTEXT NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_modified DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, html_title VARCHAR(255) NOT NULL, meta_description LONGTEXT NOT NULL, meta_keywords LONGTEXT NOT NULL, source VARCHAR(255) NOT NULL, source_url VARCHAR(255) NOT NULL, INDEX publication_datetime (publication_datetime), INDEX active_pubdatetime (active, publication_datetime), INDEX active (active), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_modified DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, comment LONGTEXT NOT NULL, email VARCHAR(255) NOT NULL, ip_address VARCHAR(255) NOT NULL, publication_datetime DATETIME DEFAULT NULL, active TINYINT(1) NOT NULL, INDEX site_list_items (active, publication_datetime), INDEX site_list_items_with_id (active, publication_datetime, id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section (id BIGINT AUTO_INCREMENT NOT NULL, parent_id BIGINT DEFAULT NULL, name VARCHAR(255) NOT NULL, html_title VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, sort_order BIGINT NOT NULL, text LONGTEXT NOT NULL, meta_description LONGTEXT NOT NULL, meta_keywords LONGTEXT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_modified DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, code VARCHAR(255) NOT NULL, INDEX parent_id (parent_id), INDEX sort_order (sort_order), INDEX order_id (sort_order, id), INDEX parent_active (parent_id, active), INDEX active (active), INDEX code (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slider_image (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, sort_order BIGINT NOT NULL, text LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slider_text (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, sort_order BIGINT NOT NULL, text LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE text_block (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_modified DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, html_title VARCHAR(255) NOT NULL, meta_description LONGTEXT NOT NULL, meta_keywords LONGTEXT NOT NULL, code VARCHAR(255) NOT NULL, INDEX code (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE text_page (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_modified DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, html_title VARCHAR(255) NOT NULL, meta_description LONGTEXT NOT NULL, meta_keywords LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, INDEX slug (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, birthdate DATETIME DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_modified DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, signature LONGTEXT NOT NULL, deleted TINYINT(1) NOT NULL, activation_key VARBINARY(255) DEFAULT NULL, avatar VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, secret_key VARBINARY(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX activation_key (activation_key), UNIQUE INDEX secret_key (secret_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_files (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, filename VARCHAR(255) NOT NULL, content_type VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_modified DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE additional ADD CONSTRAINT FK_8BD05CE6D823E37A FOREIGN KEY (section_id) REFERENCES additional_section (id)');
        $this->addSql('ALTER TABLE adjacency_list ADD CONSTRAINT FK_FDE5D6BF727ACA70 FOREIGN KEY (parent_id) REFERENCES adjacency_list (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE bind_contained ADD CONSTRAINT FK_89602878BC21F742 FOREIGN KEY (container_id) REFERENCES bind_container (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE care ADD CONSTRAINT FK_6113A845D823E37A FOREIGN KEY (section_id) REFERENCES care_section (id)');
        $this->addSql('ALTER TABLE flowers ADD CONSTRAINT FK_7DAF2300D823E37A FOREIGN KEY (section_id) REFERENCES flowers_section (id)');
        $this->addSql('ALTER TABLE interesting ADD CONSTRAINT FK_AC3BA1D6D823E37A FOREIGN KEY (section_id) REFERENCES section (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEF727ACA70 FOREIGN KEY (parent_id) REFERENCES section (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE image ADD source VARCHAR(255) NOT NULL, ADD source_url VARCHAR(255) NOT NULL, ADD alt LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE additional DROP FOREIGN KEY FK_8BD05CE6D823E37A');
        $this->addSql('ALTER TABLE adjacency_list DROP FOREIGN KEY FK_FDE5D6BF727ACA70');
        $this->addSql('ALTER TABLE bind_contained DROP FOREIGN KEY FK_89602878BC21F742');
        $this->addSql('ALTER TABLE care DROP FOREIGN KEY FK_6113A845D823E37A');
        $this->addSql('ALTER TABLE flowers DROP FOREIGN KEY FK_7DAF2300D823E37A');
        $this->addSql('ALTER TABLE interesting DROP FOREIGN KEY FK_AC3BA1D6D823E37A');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEF727ACA70');
        $this->addSql('DROP TABLE additional');
        $this->addSql('DROP TABLE additional_section');
        $this->addSql('DROP TABLE adjacency_list');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE bind_contained');
        $this->addSql('DROP TABLE bind_container');
        $this->addSql('DROP TABLE burial');
        $this->addSql('DROP TABLE care');
        $this->addSql('DROP TABLE care_section');
        $this->addSql('DROP TABLE cemetery');
        $this->addSql('DROP TABLE cemetery_section');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE feedback_form');
        $this->addSql('DROP TABLE fields_example');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE flowers');
        $this->addSql('DROP TABLE flowers_section');
        $this->addSql('DROP TABLE history_upload_image');
        $this->addSql('DROP TABLE interesting');
        $this->addSql('DROP TABLE my_sample_entity');
        $this->addSql('DROP TABLE named_timestampable');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE obituary_form');
        $this->addSql('DROP TABLE order_form');
        $this->addSql('DROP TABLE order_passport');
        $this->addSql('DROP TABLE organization');
        $this->addSql('DROP TABLE parameter');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE section');
        $this->addSql('DROP TABLE slider_image');
        $this->addSql('DROP TABLE slider_text');
        $this->addSql('DROP TABLE text_block');
        $this->addSql('DROP TABLE text_page');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_files');
        $this->addSql('ALTER TABLE image DROP source, DROP source_url, DROP alt');
    }
}
