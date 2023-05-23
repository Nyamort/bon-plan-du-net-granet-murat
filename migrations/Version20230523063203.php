<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523063203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE code_promo (id INT AUTO_INCREMENT NOT NULL, type_de_reduction_id INT NOT NULL, code VARCHAR(255) NOT NULL, expired_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', value VARCHAR(255) DEFAULT NULL, INDEX IDX_5C4683B775C8C2EE (type_de_reduction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, publication_id INT DEFAULT NULL, INDEX IDX_67F068BCA76ED395 (user_id), INDEX IDX_67F068BC38B217A7 (publication_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deal (id INT AUTO_INCREMENT NOT NULL, price NUMERIC(10, 2) NOT NULL, regular_price NUMERIC(10, 2) NOT NULL, fees NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notation (id INT AUTO_INCREMENT NOT NULL, publication_id INT NOT NULL, user_id INT NOT NULL, value SMALLINT NOT NULL, INDEX IDX_268BC9538B217A7 (publication_id), INDEX IDX_268BC95A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publication (id INT AUTO_INCREMENT NOT NULL, deal_id INT DEFAULT NULL, code_promo_id INT DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, title VARCHAR(255) NOT NULL, published_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', image VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_AF3C6779F60E2305 (deal_id), UNIQUE INDEX UNIQ_AF3C6779294102D4 (code_promo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_de_reduction (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, pseudo VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE code_promo ADD CONSTRAINT FK_5C4683B775C8C2EE FOREIGN KEY (type_de_reduction_id) REFERENCES type_de_reduction (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC38B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE notation ADD CONSTRAINT FK_268BC9538B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE notation ADD CONSTRAINT FK_268BC95A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779F60E2305 FOREIGN KEY (deal_id) REFERENCES deal (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779294102D4 FOREIGN KEY (code_promo_id) REFERENCES code_promo (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE code_promo DROP FOREIGN KEY FK_5C4683B775C8C2EE');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA76ED395');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC38B217A7');
        $this->addSql('ALTER TABLE notation DROP FOREIGN KEY FK_268BC9538B217A7');
        $this->addSql('ALTER TABLE notation DROP FOREIGN KEY FK_268BC95A76ED395');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779F60E2305');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779294102D4');
        $this->addSql('DROP TABLE code_promo');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE deal');
        $this->addSql('DROP TABLE notation');
        $this->addSql('DROP TABLE publication');
        $this->addSql('DROP TABLE type_de_reduction');
        $this->addSql('DROP TABLE user');
    }
}
