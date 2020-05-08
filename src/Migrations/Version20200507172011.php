<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200507172011 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B63ED5CA9E6');
        $this->addSql('DROP INDEX IDX_C1765B63ED5CA9E6 ON departement');
        $this->addSql('ALTER TABLE departement DROP service_id');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A762956195F');
        $this->addSql('DROP INDEX IDX_D8698A762956195F ON document');
        $this->addSql('ALTER TABLE document DROP archive_id');
        $this->addSql('ALTER TABLE typedocument ADD archive_id INT DEFAULT NULL, ADD service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE typedocument ADD CONSTRAINT FK_840004FE2956195F FOREIGN KEY (archive_id) REFERENCES typedocument (id)');
        $this->addSql('ALTER TABLE typedocument ADD CONSTRAINT FK_840004FEED5CA9E6 FOREIGN KEY (service_id) REFERENCES typedocument (id)');
        $this->addSql('CREATE INDEX IDX_840004FE2956195F ON typedocument (archive_id)');
        $this->addSql('CREATE INDEX IDX_840004FEED5CA9E6 ON typedocument (service_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE departement ADD service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B63ED5CA9E6 FOREIGN KEY (service_id) REFERENCES typedocument (id)');
        $this->addSql('CREATE INDEX IDX_C1765B63ED5CA9E6 ON departement (service_id)');
        $this->addSql('ALTER TABLE document ADD archive_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A762956195F FOREIGN KEY (archive_id) REFERENCES typedocument (id)');
        $this->addSql('CREATE INDEX IDX_D8698A762956195F ON document (archive_id)');
        $this->addSql('ALTER TABLE typedocument DROP FOREIGN KEY FK_840004FE2956195F');
        $this->addSql('ALTER TABLE typedocument DROP FOREIGN KEY FK_840004FEED5CA9E6');
        $this->addSql('DROP INDEX IDX_840004FE2956195F ON typedocument');
        $this->addSql('DROP INDEX IDX_840004FEED5CA9E6 ON typedocument');
        $this->addSql('ALTER TABLE typedocument DROP archive_id, DROP service_id');
    }
}
