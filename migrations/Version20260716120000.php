<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260716120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout d\'une contrainte unique sur user_profile.phone_number (l\'unicité de user_app.email existe déjà en base)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE UNIQUE INDEX UNIQ_USER_PROFILE_PHONE_NUMBER ON user_profile (phone_number)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX UNIQ_USER_PROFILE_PHONE_NUMBER ON user_profile');
    }
}
