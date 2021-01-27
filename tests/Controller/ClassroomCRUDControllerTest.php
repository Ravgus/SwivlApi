<?php


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;


class ClassroomCRUDControllerTest extends WebTestCase
{
    protected static ?int $id = null;

    public function testCreateClassroom(): void
    {
        $client = static::createClient();

        $name = uniqid('class');
        $isActive = true;

        $client->request('POST', '/api/classroom/create', [], [], [], json_encode([
            'name'     => $name,
            'isActive' => $isActive,
        ]));

        $this->assertResponseStatusCodeSame(201);
        $response = $client->getResponse();

        $this->checkClassroomBody($response);
        $this->checkClassroomValues($response, $name, $isActive);
    }

    public function testUpdateClassroom()
    {
        $client = static::createClient();

        $name = uniqid('class');
        $isActive = false;

        $client->request('PUT', '/api/classroom/update/' . self::$id, [], [], [], json_encode([
            'name'     => $name,
            'isActive' => $isActive,
        ]));

        $this->assertResponseStatusCodeSame(200);
        $response = $client->getResponse();

        $this->checkClassroomBody($response);
        $this->checkClassroomValues($response, $name, $isActive);
    }

    protected function checkClassroomBody(Response $response): void
    {
        $responseData = json_decode($response->getContent(), true);

        $this->assertIsArray($responseData);

        self::$id = $responseData['id'];

        $this->assertArrayHasKey('name', $responseData);
        $this->assertIsString($responseData['name']);

        $this->assertArrayHasKey('isActive', $responseData);
        $this->assertIsBool($responseData['isActive']);

        $this->assertArrayHasKey('createdAt', $responseData);
        $this->assertIsString($responseData['createdAt']);

        $this->assertArrayHasKey('id', $responseData);
        $this->assertIsInt($responseData['id']);
    }

    protected function checkClassroomValues(Response $response, string $name, bool $isActive): void
    {
        $responseData = json_decode($response->getContent(), true);

        $this->assertSame($name, $responseData['name']);
        $this->assertSame($isActive, $responseData['isActive']);
    }

    public function testShowClassroom(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/classroom/show/' . self::$id);

        $this->assertResponseStatusCodeSame(200);
        $response = $client->getResponse();

        $this->checkClassroomBody($response);
    }

    public function testDeleteClassroom(): void
    {
        $client = static::createClient();

        $client->request('DELETE', '/api/classroom/delete/' . self::$id);

        $this->assertResponseStatusCodeSame(204);
    }
}
