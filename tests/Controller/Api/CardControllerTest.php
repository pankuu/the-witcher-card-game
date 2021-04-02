<?php


namespace App\Tests\Controller\Api;


use App\Tests\DataFixtureTestCase;
use Symfony\Component\HttpFoundation\Response;


class CardControllerTest extends DataFixtureTestCase
{
    public function testCreate()
    {
        $card = [
            'title' => 'Batman',
            'power' => 6
        ];

        static::$client->request(
            'POST',
            '/api/cards',
            $card
        );

        $response = json_decode(static::$client->getResponse()->getContent(), true);

        $this->isJson();
        $this->assertArrayHasKey('status', $response);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->keepDatabaseAfterTest();
    }

    public function testCreateTitleUsed()
    {
        $card = [
            'title' => 'Geralt',
            'power' => 10
        ];

        static::$client->request(
            'POST',
            '/api/cards',
            $card
        );

        $response = json_decode(static::$client->getResponse()->getContent(), true);

        $this->isJson();
        $this->assertArrayHasKey('title', $response);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->keepDatabaseAfterTest();
    }


    public function testRemove()
    {
        static::$client->request(
            'DELETE',
            '/api/cards/6'
        );

        $this->isJson();
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
        $this->keepDatabaseAfterTest();
    }

    public function testRemoveBlockedCard()
    {
        static::$client->request(
            'DELETE',
            '/api/cards/1'
        );

        $response = json_decode(static::$client->getResponse()->getContent(), true);

        $this->isJson();
        $this->assertArrayHasKey('status', $response);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->keepDatabaseAfterTest();
    }

    public function testRemoveNoResource()
    {
        static::$client->request(
            'DELETE',
            '/api/cards/'
        );

        $response = json_decode(static::$client->getResponse()->getContent(), true);

        $this->isJson();
        $this->assertArrayHasKey('status', $response);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        $this->keepDatabaseAfterTest();
    }

    public function testUpdateBlockedCard()
    {
        $card = [
            'title' => 'Geralt Siwy',
            'power' => 10
        ];

        static::$client->request(
            'PATCH',
            '/api/cards/1',
            $card
        );

        $response = json_decode(static::$client->getResponse()->getContent(), true);

        $this->isJson();
        $this->assertArrayHasKey('status', $response);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->keepDatabaseAfterTest();
    }

    public function testUpdateNormalCard()
    {
        $card = [
            'title' => 'Geralt Siwy',
            'power' => 10
        ];

        static::$client->request(
            'POST',
            '/api/cards/1',
            $card
        );

        $newCard = [
            'title' => 'Geralt Stary',
            'power' => 1
        ];

        static::$client->request(
            'PATCH',
            '/api/cards/1',
            $newCard
        );

        $response = json_decode(static::$client->getResponse()->getContent(), true);

        $this->isJson();
        $this->assertArrayHasKey('status', $response);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->keepDatabaseAfterTest();
    }

    public function testUpdateNotFound()
    {
        $card = [
            'title' => 'Geralt Siwy',
            'power' => 10
        ];

        static::$client->request(
            'PATCH',
            '/api/cards/',
            $card
        );

        $response = json_decode(static::$client->getResponse()->getContent(), true);

        $this->isJson();
        $this->assertArrayHasKey('status', $response);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        $this->keepDatabaseAfterTest();
    }

    public function testList()
    {
        static::$client->request(
            'GET',
            '/api/cards'
        );

        $response = json_decode(static::$client->getResponse()->getContent(), true);

        $this->isJson();
        $this->assertArrayHasKey('status', $response);
        $this->assertArrayHasKey('data', $response);
        $this->assertArrayHasKey('links', $response);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
