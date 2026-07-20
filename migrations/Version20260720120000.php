<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260720120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return "Création de la table recording (enregistrements vidéo des séances)";
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE recording (id INT AUTO_INCREMENT NOT NULL, course_session_id INT NOT NULL, uploaded_by_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, filename VARCHAR(255) NOT NULL, original_filename VARCHAR(255) NOT NULL, mime_type VARCHAR(100) NOT NULL, file_size INT NOT NULL, uploaded_at DATETIME NOT NULL, INDEX IDX_BB532B53BEDDA25C (course_session_id), INDEX IDX_BB532B53A2B28FE8 (uploaded_by_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE recording ADD CONSTRAINT FK_BB532B53BEDDA25C FOREIGN KEY (course_session_id) REFERENCES course_session (id)');
        $this->addSql('ALTER TABLE recording ADD CONSTRAINT FK_BB532B53A2B28FE8 FOREIGN KEY (uploaded_by_id) REFERENCES user_app (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE recording DROP FOREIGN KEY FK_BB532B53BEDDA25C');
        $this->addSql('ALTER TABLE recording DROP FOREIGN KEY FK_BB532B53A2B28FE8');
        $this->addSql('DROP TABLE recording');
    }
}
