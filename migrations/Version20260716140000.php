<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260716140000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout de la colonne max_students sur membership_plan (limite de places par formation)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE membership_plan ADD max_students INT NOT NULL DEFAULT 0');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE membership_plan DROP max_students');
    }
}
