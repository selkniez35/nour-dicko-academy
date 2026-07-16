<?php
declare(strict_types=1);
namespace DoctrineMigrations;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260702103958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Migration initiale pour MariaDB';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE membership_plan (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(100) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, internal_ref VARCHAR(255) NOT NULL, stripe_session_id VARCHAR(255) NOT NULL, stripe_payment_intent VARCHAR(255) DEFAULT NULL, status VARCHAR(20) NOT NULL, amount INT NOT NULL, created_at DATETIME NOT NULL, paid_at DATETIME DEFAULT NULL, last_stripe_event_id VARCHAR(255) DEFAULT NULL, method VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6D28840DF70CD362 ON payment (internal_ref)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6D28840D1A314A57 ON payment (stripe_session_id)');
        $this->addSql('CREATE INDEX stripe_session_idx ON payment (stripe_session_id)');
        $this->addSql('CREATE TABLE stripe_event_log (event_id VARCHAR(255) NOT NULL, type VARCHAR(100) NOT NULL, payload JSON NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY (event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 ON messenger_messages (queue_name, available_at, delivered_at, id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE membership_plan');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE stripe_event_log');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
