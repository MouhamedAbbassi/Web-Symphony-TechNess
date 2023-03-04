<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230304143345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `like` (id INT AUTO_INCREMENT NOT NULL, evenement_id INT NOT NULL, INDEX IDX_AC6340B3FD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE user ADD likes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6492F23775F FOREIGN KEY (likes_id) REFERENCES `like` (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6492F23775F ON user (likes_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6492F23775F');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3FD02F13');
        $this->addSql('DROP TABLE `like`');
        $this->addSql('DROP INDEX IDX_8D93D6492F23775F ON `user`');
        $this->addSql('ALTER TABLE `user` DROP likes_id');
    }
}
