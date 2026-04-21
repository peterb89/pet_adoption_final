<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260421224048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal_comment (id INT AUTO_INCREMENT NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL, animal_id INT DEFAULT NULL, INDEX IDX_1BAB3D568E962C16 (animal_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE animal_comment_user (animal_comment_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_19BFC55E259CA5F7 (animal_comment_id), INDEX IDX_19BFC55EA76ED395 (user_id), PRIMARY KEY (animal_comment_id, user_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE housing_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone_number VARCHAR(20) DEFAULT NULL, city VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, housing_type_id INT DEFAULT NULL, INDEX IDX_8157AA0F7CB1EF5B (housing_type_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL, is_verified TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE animal_comment ADD CONSTRAINT FK_1BAB3D568E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE animal_comment_user ADD CONSTRAINT FK_19BFC55E259CA5F7 FOREIGN KEY (animal_comment_id) REFERENCES animal_comment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE animal_comment_user ADD CONSTRAINT FK_19BFC55EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F7CB1EF5B FOREIGN KEY (housing_type_id) REFERENCES housing_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal_comment DROP FOREIGN KEY FK_1BAB3D568E962C16');
        $this->addSql('ALTER TABLE animal_comment_user DROP FOREIGN KEY FK_19BFC55E259CA5F7');
        $this->addSql('ALTER TABLE animal_comment_user DROP FOREIGN KEY FK_19BFC55EA76ED395');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0F7CB1EF5B');
        $this->addSql('DROP TABLE animal_comment');
        $this->addSql('DROP TABLE animal_comment_user');
        $this->addSql('DROP TABLE housing_type');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
