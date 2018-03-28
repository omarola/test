<?php

namespace Application\Migrations;

use AppBundle\Entity\Category;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180327171946 extends AbstractMigration implements ContainerAwareInterface
{
    /**
     *
     */
    private $container;

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs

    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function postUp(Schema $schema)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');

        for ($i = 0; $i < 10; $i++) {
            /*$category = 'category '.$i;
            $test = 'test'.$i;
            $this->addSql('UPDATE category SET NAME = '.$category.' WHERE NAME = '.$test );*/

            $name = 'test' . $i;

            $category = $em->getRepository(Category::class)->findByName($name);

            $category->setName('category' . $i);

            $em->flush();

        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
