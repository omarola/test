<?php

namespace AppBundle\Tests\Controller;
use AppBundle\Controller\CatalogController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CatalogControllerTest extends WebTestCase
{
    public function testShowPost()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/category');



    }
}