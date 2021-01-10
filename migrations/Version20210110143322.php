<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210110143322 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, formation_id INT NOT NULL, entreprise_id INT NOT NULL, intitule VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, date_debut DATETIME NOT NULL, duree INT NOT NULL, competences_requises LONGTEXT DEFAULT NULL, experience_requise LONGTEXT DEFAULT NULL, INDEX IDX_C27C93695200282E (formation_id), INDEX IDX_C27C9369A4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C93695200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE stage');
    }
}
