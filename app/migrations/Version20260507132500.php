<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260507132500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adoption_application ADD experience LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE animal ADD size VARCHAR(20) DEFAULT NULL, ADD gender VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE profile CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adoption_application DROP experience');
        $this->addSql('ALTER TABLE animal DROP size, DROP gender');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FA76ED395');
        $this->addSql('ALTER TABLE profile CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT `FK_8157AA0FA76ED395` FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
