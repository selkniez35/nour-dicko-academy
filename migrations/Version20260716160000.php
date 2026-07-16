<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260716160000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création de la table course_session_student (élèves inscrits à une séance/classe)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE course_session_student (course_session_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_5F1B9C0E9CF0DD9D (course_session_id), INDEX IDX_5F1B9C0EA76ED395 (user_id), PRIMARY KEY (course_session_id, user_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE course_session_student ADD CONSTRAINT FK_5F1B9C0E9CF0DD9D FOREIGN KEY (course_session_id) REFERENCES course_session (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_session_student ADD CONSTRAINT FK_5F1B9C0EA76ED395 FOREIGN KEY (user_id) REFERENCES user_app (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE course_session_student DROP FOREIGN KEY FK_5F1B9C0E9CF0DD9D');
        $this->addSql('ALTER TABLE course_session_student DROP FOREIGN KEY FK_5F1B9C0EA76ED395');
        $this->addSql('DROP TABLE course_session_student');
    }
}
