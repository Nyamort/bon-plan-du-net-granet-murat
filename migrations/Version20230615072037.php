<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230615072037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users_publications_alert (user_id INT NOT NULL, publication_id INT NOT NULL, INDEX IDX_32FCADA4A76ED395 (user_id), INDEX IDX_32FCADA438B217A7 (publication_id), PRIMARY KEY(user_id, publication_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_publications_alert ADD CONSTRAINT FK_32FCADA4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_publications_alert ADD CONSTRAINT FK_32FCADA438B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_publications_alert DROP FOREIGN KEY FK_32FCADA4A76ED395');
        $this->addSql('ALTER TABLE users_publications_alert DROP FOREIGN KEY FK_32FCADA438B217A7');
        $this->addSql('DROP TABLE users_publications_alert');
    }
}
