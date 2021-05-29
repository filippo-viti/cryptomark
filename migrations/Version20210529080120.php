<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210529080120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9505CCB95E237E06 ON algorithm (name)');
        $this->addSql('ALTER TABLE comment ADD algorithm_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CBBEB6CF7 FOREIGN KEY (algorithm_id) REFERENCES algorithm (id)');
        $this->addSql('CREATE INDEX IDX_9474526CBBEB6CF7 ON comment (algorithm_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_9505CCB95E237E06 ON algorithm');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CBBEB6CF7');
        $this->addSql('DROP INDEX IDX_9474526CBBEB6CF7 ON comment');
        $this->addSql('ALTER TABLE comment DROP algorithm_id');
    }
}
