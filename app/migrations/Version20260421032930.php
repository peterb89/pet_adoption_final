<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260421032930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, breed VARCHAR(100) DEFAULT NULL, age INT DEFAULT NULL, location VARCHAR(150) DEFAULT NULL, status VARCHAR(50) NOT NULL, species_id INT DEFAULT NULL, INDEX IDX_6AAB231FB2A1D860 (species_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE animal_tag (id INT AUTO_INCREMENT NOT NULL, animal_id INT DEFAULT NULL, tag_id INT DEFAULT NULL, INDEX IDX_9C07FC6D8E962C16 (animal_id), INDEX IDX_9C07FC6DBAD26311 (tag_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE species (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FB2A1D860 FOREIGN KEY (species_id) REFERENCES species (id)');
        $this->addSql('ALTER TABLE animal_tag ADD CONSTRAINT FK_9C07FC6D8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE animal_tag ADD CONSTRAINT FK_9C07FC6DBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FB2A1D860');
        $this->addSql('ALTER TABLE animal_tag DROP FOREIGN KEY FK_9C07FC6D8E962C16');
        $this->addSql('ALTER TABLE animal_tag DROP FOREIGN KEY FK_9C07FC6DBAD26311');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE animal_tag');
        $this->addSql('DROP TABLE species');
        $this->addSql('DROP TABLE tag');
    }
}
