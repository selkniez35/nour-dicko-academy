<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260716130000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Corrige course_session.teacher_id pour référencer user_app au lieu de la table orpheline teacher';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE course_session DROP FOREIGN KEY FK_D887D03841807E1D');
        $this->addSql('ALTER TABLE course_session ADD CONSTRAINT FK_D887D03841807E1D FOREIGN KEY (teacher_id) REFERENCES user_app (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE course_session DROP FOREIGN KEY FK_D887D03841807E1D');
        $this->addSql('ALTER TABLE course_session ADD CONSTRAINT FK_D887D03841807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
    }
}
