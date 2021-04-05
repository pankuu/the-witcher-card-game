<?php


namespace App\Tests\Controller\Api;


use App\Tests\DataFixtureTestCase;
use Symfony\Component\HttpFoundation\Response;


class CardControllerTest extends DataFixtureTestCase
{
    public function testCreate(): void
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

    public function testCreateTitleUsed(): void
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


    public function testRemove(): void
    {
        static::$client->request(
            'DELETE',
            '/api/cards/Batman'
        );

        $this->isJson();
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->keepDatabaseAfterTest();
    }

    public function testRemoveBlockedCard(): void
    {
        static::$client->request(
            'DELETE',
            '/api/cards/Geralt'
        );

        $response = json_decode(static::$client->getResponse()->getContent(), true);

        $this->isJson();
        $this->assertArrayHasKey('status', $response);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->keepDatabaseAfterTest();
    }

    public function testRemoveNoResource(): void
    {
        $card = [
            'title' => 'BatmanTest',
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

        static::$client->request(
            'DELETE',
            "/api/cards/BatmanTes"
        );

        $this->isJson();
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        $this->keepDatabaseAfterTest();
    }

    public function testUpdateBlockedCard(): void
    {
        $card = [
            'title' => 'Geralt Siwy',
            'power' => 10
        ];

        static::$client->request(
            'PATCH',
            '/api/cards/Geralt',
            $card
        );

        $response = json_decode(static::$client->getResponse()->getContent(), true);

        $this->isJson();
        $this->assertArrayHasKey('status', $response);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->keepDatabaseAfterTest();
    }

    public function testUpdateNormalCard(): void
    {
        $card = [
            'title' => 'Geralt Srebrny',
            'power' => 10
        ];

        static::$client->request(
            'POST',
            '/api/cards',
            $card
        );

        $newCard = [
            'title' => 'Geralt Srebrny',
            'power' => 1
        ];

        static::$client->request(
            'PATCH',
            "/api/cards/{$card['title']}",
            $newCard
        );

        $response = json_decode(static::$client->getResponse()->getContent(), true);

        $this->isJson();
        $this->assertArrayHasKey('title', $response);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        $this->keepDatabaseAfterTest();
    }

    public function testUpdateNotFound(): void
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

        $this->isJson();
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        $this->keepDatabaseAfterTest();
    }

    public function testList(): void
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
        $this->keepDatabaseAfterTest();
    }
}
