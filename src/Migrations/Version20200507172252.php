<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200507172252 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE typedocument DROP FOREIGN KEY FK_840004FE2956195F');
        $this->addSql('ALTER TABLE typedocument DROP FOREIGN KEY FK_840004FEED5CA9E6');
        $this->addSql('ALTER TABLE typedocument ADD CONSTRAINT FK_840004FE2956195F FOREIGN KEY (archive_id) REFERENCES document (id)');
        $this->addSql('ALTER TABLE typedocument ADD CONSTRAINT FK_840004FEED5CA9E6 FOREIGN KEY (service_id) REFERENCES departement (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE typedocument DROP FOREIGN KEY FK_840004FE2956195F');
        $this->addSql('ALTER TABLE typedocument DROP FOREIGN KEY FK_840004FEED5CA9E6');
        $this->addSql('ALTER TABLE typedocument ADD CONSTRAINT FK_840004FE2956195F FOREIGN KEY (archive_id) REFERENCES typedocument (id)');
        $this->addSql('ALTER TABLE typedocument ADD CONSTRAINT FK_840004FEED5CA9E6 FOREIGN KEY (service_id) REFERENCES typedocument (id)');
    }
}
