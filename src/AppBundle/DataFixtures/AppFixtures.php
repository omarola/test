<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
       {
        for ($i = 0; $i < 10; $i++)
        {
            $product = new Category();
            $product->setName('test '.$i);
            $id = mt_rand(89,140);
            $parent = $manager->getRepository(Category::class)->find($id);
            $product->setParent($parent);
            $manager->persist($product);
        }

        $manager->flush();
    }
}