<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Aligne les valeurs existantes de membership.payment_method sur les valeurs
 * de l'enum PaymentMethod (le formulaire public envoyait 'virement'/'especes',
 * l'enum utilise 'bank_transfer'/'cash').
 */
final class Version20260717090000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return "Normalise membership.payment_method vers les valeurs de l'enum PaymentMethod";
    }

    public function up(Schema $schema): void
    {
        $this->addSql("UPDATE membership SET payment_method = 'bank_transfer' WHERE payment_method = 'virement'");
        $this->addSql("UPDATE membership SET payment_method = 'cash' WHERE payment_method = 'especes'");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("UPDATE membership SET payment_method = 'virement' WHERE payment_method = 'bank_transfer'");
        $this->addSql("UPDATE membership SET payment_method = 'especes' WHERE payment_method = 'cash'");
    }
}
