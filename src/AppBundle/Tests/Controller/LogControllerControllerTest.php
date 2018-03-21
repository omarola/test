<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LogControllerControllerTest extends WebTestCase
{
    public function testGetlog()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'log');
    }

}
