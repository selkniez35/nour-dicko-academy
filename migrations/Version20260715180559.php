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
        return 'Création de la table course_session (séances datées liées à une classe et un enseignant)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE course_session (id INT AUTO_INCREMENT NOT NULL, starts_at DATETIME NOT NULL, ends_at DATETIME DEFAULT NULL, room VARCHAR(100) DEFAULT NULL, notes VARCHAR(255) DEFAULT NULL, plan_id INT NOT NULL, teacher_id INT DEFAULT NULL, INDEX IDX_D887D038E899029B (plan_id), INDEX IDX_D887D03841807E1D (teacher_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE course_session ADD CONSTRAINT FK_D887D038E899029B FOREIGN KEY (plan_id) REFERENCES membership_plan (id)');
        $this->addSql('ALTER TABLE course_session ADD CONSTRAINT FK_D887D03841807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE course_session DROP FOREIGN KEY FK_D887D038E899029B');
        $this->addSql('ALTER TABLE course_session DROP FOREIGN KEY FK_D887D03841807E1D');
        $this->addSql('DROP TABLE course_session');
    }
}
