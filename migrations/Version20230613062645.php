<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230613062645 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_publication (user_id INT NOT NULL, publication_id INT NOT NULL, INDEX IDX_627AEECA76ED395 (user_id), INDEX IDX_627AEEC38B217A7 (publication_id), PRIMARY KEY(user_id, publication_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_publication ADD CONSTRAINT FK_627AEECA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_publication ADD CONSTRAINT FK_627AEEC38B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_publication DROP FOREIGN KEY FK_627AEECA76ED395');
        $this->addSql('ALTER TABLE user_publication DROP FOREIGN KEY FK_627AEEC38B217A7');
        $this->addSql('DROP TABLE user_publication');
    }
}
