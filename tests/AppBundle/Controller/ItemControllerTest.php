<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ItemControllerTest extends WebTestCase
{
    /**
     * Create a client with a default Authorization header.
     *
     * @param string $username
     * @param string $password
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function createAuthenticatedClient($username = 'user', $password = 'user')
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/login_check',
            array(
                'username' => $username,
                'password' => $password,
            )
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        if (isset($data['token'])) {
            $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));
            $client->setServerParameter('CONTENT_TYPE', 'application/json');
        }

        return $client;
    }

    public function testGetAllItemsAction()
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/items');
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
    }

    public function testGetItemByIdAction()
    {
        $client = $this->createAuthenticatedClient();
        $expected = '{"id":1,"name":"Bike2","categories":[],"attributes":[{"id":1,"value":"120","attribute":{"id":1,"alias":"price","name":"price"}}]}';
        $client->request('GET', '/item/1');
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertEquals($expected, $response->getContent());
    }

    public function testPostItemAction()
    {
        $client = $this->createAuthenticatedClient();
        $content = '{"value": "1200","item":{ "name": "test", "categories": []}, "attribute": {"id": 1}}';
        $expected = 'DONE!';
        $client->request('POST', '/item',[], [], [], $content);
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertEquals($expected, $response->getContent());
    }

    public function testUpdateItemAction()
    {
        $client = $this->createAuthenticatedClient();
        $content = '{"id":1,"name": "Bike2"}';
        $expected = 'Update was successful!';
        $client->request('PATCH', '/item',[], [], [], $content);
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertEquals($expected, $response->getContent());
    }

    public function testDeleteItemAction()
    {
        $client = $this->createAuthenticatedClient();
        $client->request('DELETE', '/item/4');
        $response = $client->getResponse();
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());
    }
}