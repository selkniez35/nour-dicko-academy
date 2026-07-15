<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260715180559 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course_session (id INT AUTO_INCREMENT NOT NULL, starts_at DATETIME NOT NULL, ends_at DATETIME DEFAULT NULL, room VARCHAR(100) DEFAULT NULL, notes VARCHAR(255) DEFAULT NULL, plan_id INT NOT NULL, teacher_id INT DEFAULT NULL, INDEX IDX_D887D038E899029B (plan_id), INDEX IDX_D887D03841807E1D (teacher_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE course_session ADD CONSTRAINT FK_D887D038E899029B FOREIGN KEY (plan_id) REFERENCES membership_plan (id)');
        $this->addSql('ALTER TABLE course_session ADD CONSTRAINT FK_D887D03841807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE announcement CHANGE published_at published_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE document CHANGE filename filename VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE emergency_contact CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE relationship relationship VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE membership CHANGE status_reason status_reason VARCHAR(255) DEFAULT NULL, CHANGE student_level student_level VARCHAR(255) DEFAULT NULL, CHANGE payment_mode payment_mode VARCHAR(50) DEFAULT NULL, CHANGE payment_method payment_method VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE payment CHANGE stripe_payment_intent stripe_payment_intent VARCHAR(255) DEFAULT NULL, CHANGE paid_at paid_at DATETIME DEFAULT NULL, CHANGE last_stripe_event_id last_stripe_event_id VARCHAR(255) DEFAULT NULL, CHANGE method method VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE stripe_event_log CHANGE payload payload JSON NOT NULL');
        $this->addSql('ALTER TABLE user_app CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE user_profile CHANGE first_name first_name VARCHAR(255) DEFAULT NULL, CHANGE date_of_birth date_of_birth DATE DEFAULT NULL, CHANGE place_of_birth place_of_birth VARCHAR(255) DEFAULT NULL, CHANGE address address VARCHAR(255) DEFAULT NULL, CHANGE preferred_group preferred_group VARCHAR(32) DEFAULT NULL, CHANGE personal_objective personal_objective VARCHAR(255) DEFAULT NULL, CHANGE phone_number phone_number VARCHAR(20) DEFAULT NULL, CHANGE gender gender VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course_session DROP FOREIGN KEY FK_D887D038E899029B');
        $this->addSql('ALTER TABLE course_session DROP FOREIGN KEY FK_D887D03841807E1D');
        $this->addSql('DROP TABLE course_session');
        $this->addSql('ALTER TABLE announcement CHANGE published_at published_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE document CHANGE filename filename VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE emergency_contact CHANGE email email VARCHAR(255) DEFAULT \'NULL\', CHANGE relationship relationship VARCHAR(100) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE membership CHANGE status_reason status_reason VARCHAR(255) DEFAULT \'NULL\', CHANGE student_level student_level VARCHAR(255) DEFAULT \'NULL\', CHANGE payment_mode payment_mode VARCHAR(50) DEFAULT \'NULL\', CHANGE payment_method payment_method VARCHAR(50) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE payment CHANGE stripe_payment_intent stripe_payment_intent VARCHAR(255) DEFAULT \'NULL\', CHANGE paid_at paid_at DATETIME DEFAULT \'NULL\', CHANGE last_stripe_event_id last_stripe_event_id VARCHAR(255) DEFAULT \'NULL\', CHANGE method method VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE stripe_event_log CHANGE payload payload LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE user_app CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE user_profile CHANGE first_name first_name VARCHAR(255) DEFAULT \'NULL\', CHANGE date_of_birth date_of_birth DATE DEFAULT \'NULL\', CHANGE place_of_birth place_of_birth VARCHAR(255) DEFAULT \'NULL\', CHANGE address address VARCHAR(255) DEFAULT \'NULL\', CHANGE phone_number phone_number VARCHAR(20) DEFAULT \'NULL\', CHANGE gender gender VARCHAR(10) DEFAULT \'NULL\', CHANGE preferred_group preferred_group VARCHAR(32) DEFAULT \'NULL\', CHANGE personal_objective personal_objective VARCHAR(255) DEFAULT \'NULL\'');
    }
}
