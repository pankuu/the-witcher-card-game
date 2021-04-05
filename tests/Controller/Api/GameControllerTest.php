<?php


namespace App\Tests\Controller\Api;


use App\Tests\DataFixtureTestCase;
use Symfony\Component\HttpFoundation\Response;

class GameControllerTest extends DataFixtureTestCase
{
    public function testPlay(): void
    {
        $deck = ['name' =>'Deck'];

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

        $data = array_merge($card, $deck);

        static::$client->request(
            'PUT',
            '/api/decks',
            $data
        );

        $this->isJson();
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        $deck1 = ['name' =>'Deck1'];

        static::$client->request(
            'POST',
            '/api/decks',
            $deck1
        );

        $this->isJson();
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $card = [
            'cards' => 'Geralt'
        ];

        $data = array_merge($card, $deck);

        static::$client->request(
            'PUT',
            '/api/decks',
            $data
        );

        $this->isJson();
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        $data = [
            'host' => $deck['name'],
            'guest' => $deck1['name'],
            'numberOfCards' => 1
        ];

        static::$client->request(
            'POST',
            '/api/games',
            $data
        );

        $response = json_decode(static::$client->getResponse()->getContent(), true);

        $this->isJson();
        $this->assertArrayHasKey('message', $response);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
