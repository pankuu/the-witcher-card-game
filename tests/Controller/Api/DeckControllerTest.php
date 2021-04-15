<?php

namespace App\Tests\Controller\Api;

use App\Tests\DataFixtureTestCase;
use Symfony\Component\HttpFoundation\Response;

class DeckControllerTest extends DataFixtureTestCase
{
    public function testCreate(): void
    {
        $deck = ['name' =>'DeckTest'];

        static::$client->request(
            'POST',
            '/api/decks',
            $deck
        );

        $response = json_decode(static::$client->getResponse()->getContent(), true);

        $this->isJson();
        $this->assertArrayHasKey('status', $response);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->keepDatabaseAfterTest();
    }

    public function testCreateFailed(): void
    {
        $deck = ['name' => null];

        static::$client->request(
            'POST',
            '/api/decks',
            $deck
        );

        $response = json_decode(static::$client->getResponse()->getContent(), true);

        $this->isJson();
        $this->assertArrayHasKey('status', $response);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->keepDatabaseAfterTest();
    }

    public function testAddCardToDeck(): void
    {
        $deck = ['name' =>'DeckTest1'];

        static::$client->request(
            'POST',
            '/api/decks',
            $deck
        );

        $this->isJson();
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $card = [
            'cards' => 'Ciri'
        ];

        static::$client->request(
            'PUT',
            "/api/decks/{$deck['name']}",
            [],
            [],
            [],
            json_encode($card)
        );

        $this->isJson();
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
        $this->keepDatabaseAfterTest();
    }

    public function testAddCardToDeckFailed(): void
    {
        $deck = ['name' =>'DeckTest2'];

        static::$client->request(
            'POST',
            '/api/decks',
            $deck
        );

        $response = json_decode(static::$client->getResponse()->getContent(), true);

        $this->isJson();
        $this->assertArrayHasKey('status', $response);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $card = ['cards' => 'CardTestFailed'];

        static::$client->request(
            'PUT',
            "/api/decks/{$deck['name']}",
            [],
            [],
            [],
            json_encode($card)
        );

        $response = json_decode(static::$client->getResponse()->getContent(), true);

        $this->isJson();
        $this->assertArrayHasKey('status', $response);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->keepDatabaseAfterTest();
    }

    public function testRemoveCardFromDeck(): void
    {
        $deck = ['name' =>'DeckTest3'];

        static::$client->request(
            'POST',
            '/api/decks',
            $deck
        );

        $response = json_decode(static::$client->getResponse()->getContent(), true);

        $this->isJson();
        $this->assertArrayHasKey('status', $response);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $card = [
            'cards' => 'Ciri'
        ];

        static::$client->request(
            'PUT',
            "/api/decks/${deck['name']}",
            [],
            [],
            [],
            json_encode($card)
        );

        $this->isJson();
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        static::$client->request(
            'DELETE',
            "/api/decks/{$deck['name']}/cards/{$card['cards']}"
        );

        $response = json_decode(static::$client->getResponse()->getContent(), true);

        $this->isJson();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertArrayHasKey('status', $response);
        $this->keepDatabaseAfterTest();
    }
}
