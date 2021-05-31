<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210530210754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cpu (id INT AUTO_INCREMENT NOT NULL, manufacturer VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, cores INT NOT NULL, threads INT NOT NULL, clock_speed NUMERIC(3, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE benchmark ADD cpu_id INT NOT NULL, DROP cpu');
        $this->addSql('ALTER TABLE benchmark ADD CONSTRAINT FK_B70C48FE3917014 FOREIGN KEY (cpu_id) REFERENCES cpu (id)');
        $this->addSql('CREATE INDEX IDX_B70C48FE3917014 ON benchmark (cpu_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE benchmark DROP FOREIGN KEY FK_B70C48FE3917014');
        $this->addSql('DROP TABLE cpu');
        $this->addSql('DROP INDEX IDX_B70C48FE3917014 ON benchmark');
        $this->addSql('ALTER TABLE benchmark ADD cpu VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP cpu_id');
    }
}
