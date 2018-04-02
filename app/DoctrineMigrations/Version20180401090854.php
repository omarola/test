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
class Version20180401090854 extends ContainerAwareInterface
{
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
        $em = $this->container->get('doctrine.orm.entity_manager');
        for ($i = 0; $i < 10; $i++) {
            $name = 'test' . $i;
            $category = $em->getRepository(Category::class)->findByName($name);
            if ($category instanceof Category && is_null($category)) {
                $category->setName('category' . $i);
                $em->persist($category);
                $em->flush();
            } elseif ($em->getRepository(Category::class)->findByName('category' . $i)->getName() == 'category' . $i) {
                return;
            } else {
                $category->setName('category' . $i);
                $em->flush();
            }
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
