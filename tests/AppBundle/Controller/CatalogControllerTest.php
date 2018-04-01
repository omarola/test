<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CatalogControllerTest extends WebTestCase
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

    public function testGetAllCategoryAction()
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/category');
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
    }

    public function testGetCategoryByIdAction()
    {
        $client = $this->createAuthenticatedClient();
        $expected = '{"id":3,"name":"category3","parent":{"id":1,"name":"newCategory"}}';
        $client->request('GET', '/category/3');
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertEquals($expected, $response->getContent());
    }

    public function testPostCategoryAction()
    {
        $client = $this->createAuthenticatedClient();
        $content = '{"name": "QACategory","parent": {"id":3}}';
        $expected = 'DONE!';
        $client->request('POST', '/category',[], [], [], $content);
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertEquals($expected, $response->getContent());
    }

    public function testUpdateCategoryAction()
    {
        $client = $this->createAuthenticatedClient();
        $content = '{"id":1,"name": "newCategory"}';
        $expected = 'Update was successful!';
        $client->request('PATCH', '/category',[], [], [], $content);
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertEquals($expected, $response->getContent());
    }

    public function testDeleteCategoryAction()
    {
        $client = $this->createAuthenticatedClient();
        $client->request('DELETE', '/category/2');
        $response = $client->getResponse();
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());
    }
}