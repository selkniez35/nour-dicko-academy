<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260710194358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announcement CHANGE published_at published_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE coach_note CHANGE personal_objective personal_objective VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE document CHANGE filename filename VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE emergency_contact CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE relationship relationship VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE event_registration CHANGE checked_in_at checked_in_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE membership ADD student_level VARCHAR(255) DEFAULT NULL, ADD payment_mode VARCHAR(50) DEFAULT NULL, ADD payment_method VARCHAR(50) DEFAULT NULL, CHANGE status_reason status_reason VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE payment CHANGE stripe_payment_intent stripe_payment_intent VARCHAR(255) DEFAULT NULL, CHANGE paid_at paid_at DATETIME DEFAULT NULL, CHANGE last_stripe_event_id last_stripe_event_id VARCHAR(255) DEFAULT NULL, CHANGE method method VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE stripe_event_log CHANGE payload payload JSON NOT NULL');
        $this->addSql('ALTER TABLE training_booking CHANGE checked_in_at checked_in_at DATETIME DEFAULT NULL, CHANGE cancelled_at cancelled_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE training_session CHANGE level level VARCHAR(32) DEFAULT \'INTERMEDIATE\' NOT NULL');
        $this->addSql('ALTER TABLE user_app CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE user_profile ADD phone_number VARCHAR(20) DEFAULT NULL, ADD gender VARCHAR(10) DEFAULT NULL, CHANGE first_name first_name VARCHAR(255) DEFAULT NULL, CHANGE date_of_birth date_of_birth DATE DEFAULT NULL, CHANGE place_of_birth place_of_birth VARCHAR(255) DEFAULT NULL, CHANGE address address VARCHAR(255) DEFAULT NULL, CHANGE preferred_group preferred_group VARCHAR(32) DEFAULT NULL, CHANGE personal_objective personal_objective VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announcement CHANGE published_at published_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE coach_note CHANGE personal_objective personal_objective VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE document CHANGE filename filename VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE emergency_contact CHANGE email email VARCHAR(255) DEFAULT \'NULL\', CHANGE relationship relationship VARCHAR(100) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE event_registration CHANGE checked_in_at checked_in_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE membership DROP student_level, DROP payment_mode, DROP payment_method, CHANGE status_reason status_reason VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE payment CHANGE stripe_payment_intent stripe_payment_intent VARCHAR(255) DEFAULT \'NULL\', CHANGE paid_at paid_at DATETIME DEFAULT \'NULL\', CHANGE last_stripe_event_id last_stripe_event_id VARCHAR(255) DEFAULT \'NULL\', CHANGE method method VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE stripe_event_log CHANGE payload payload LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE training_booking CHANGE checked_in_at checked_in_at DATETIME DEFAULT \'NULL\', CHANGE cancelled_at cancelled_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE training_session CHANGE level level VARCHAR(32) DEFAULT \'\'\'INTERMEDIATE\'\'\' NOT NULL');
        $this->addSql('ALTER TABLE user_app CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE user_profile DROP phone_number, DROP gender, CHANGE first_name first_name VARCHAR(255) DEFAULT \'NULL\', CHANGE date_of_birth date_of_birth DATE DEFAULT \'NULL\', CHANGE place_of_birth place_of_birth VARCHAR(255) DEFAULT \'NULL\', CHANGE address address VARCHAR(255) DEFAULT \'NULL\', CHANGE preferred_group preferred_group VARCHAR(32) DEFAULT \'NULL\', CHANGE personal_objective personal_objective VARCHAR(255) DEFAULT \'NULL\'');
    }
}
