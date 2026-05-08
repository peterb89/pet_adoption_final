<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260508121500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add photo_filename columns for profile and animal uploads';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE animal ADD photo_filename VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE profile ADD photo_filename VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE animal DROP photo_filename');
        $this->addSql('ALTER TABLE profile DROP photo_filename');
    }
}
