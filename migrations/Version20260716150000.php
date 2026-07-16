<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260716150000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Remplace le rôle ROLE_USER (retiré) par ROLE_STUDENT pour les comptes existants';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("UPDATE user_app SET roles = '[\"ROLE_STUDENT\"]' WHERE roles = '[\"ROLE_USER\"]'");
        $this->addSql("UPDATE user_app SET roles = '[\"ROLE_STUDENT\"]' WHERE roles = '[\"ROLE_USER, ROLE_STUDENT\"]'");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("UPDATE user_app SET roles = '[\"ROLE_USER\"]' WHERE roles = '[\"ROLE_STUDENT\"]'");
    }
}
