<?php

namespace App\Controller\Api;

use App\Entity\Card;
use App\Entity\Deck;
use App\Entity\DeckCard;
use App\Repository\CardRepository;
use App\Repository\DeckCardRepository;
use App\Repository\DeckRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class DeckController
 * @package App\Controller\Api
 * @Route("/api", name="api_")
 */
class DeckController extends AbstractController
{
    /**
     * @Route("/decks", name="api_decks", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $name = $request->get('name');

        if (!$name) {
            return $this->json(['status' => 'Deck name is mandatory.'], Response::HTTP_BAD_REQUEST);
        }

        $deck = new Deck();
        $deck->setName($name);

        $em = $this->getDoctrine()->getManager();
        $em->persist($deck);
        $em->flush();

        return $this->json(['status' => 'Deck successfully added.'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/decks", name="api_decks_card", methods={"PUT"})
     */
    public function addCard(Request $request, DeckRepository $deckRepository,
        CardRepository $cardRepository, DeckCardRepository $deckCardRepository): JsonResponse
    {
        $name = $request->get('name');
        $cards = $request->get('cards');

        $deck = $deckRepository->findOneBy(['name' => $name]);

        $deckCards = $deckCardRepository->findBy(['deck_id' => $deck->getId()]);

        if (count($deckCards) > 10) {
            return $this->json([
                'status' => 'The maximum number of cards (10) in the deck has been reached.'
            ], Response::HTTP_OK);
        }

        $em = $this->getDoctrine()->getManager();

        if (!$deck) {
            $deck = new Deck();
            $deck->setName($name);
            $em->persist($deck);
            $em->flush();
        }

        $items = explode(',', $cards);

        $errors = [];
        foreach ($items as $item) {
            $card = $cardRepository->findOneBy(['title' => $item]);

            if (!$card) {
                $errors['status'][] = "Wrong card name: {$item}";
                break;
            }

            $data = $deckCardRepository->findBy(['card_id' => $card->getId(), 'deck_id' => $deck->getId()]);

            if (count($data) < 2 || count($deckCards) > 10) {
                $deckCard = new DeckCard();
                $deckCard->setDeckId($deck->getId());
                $deckCard->setCardId($card->getId());
                $em->persist($deckCard);
            } else {
                $errors['status'][] = "You can add max 2 same card {$item} to deck.";
            }
        }
        $em->flush();

        if ($errors) {
            return $this->json($errors, 400);
        }

        return $this->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/decks/{name}/cards/{title}", name="api_remove_decks_card", methods={"DELETE"})
     */
    public function remove(Deck $deck, Card $card, DeckCardRepository $deckCardRepository): JsonResponse
    {
        $cardId = $card->getId();
        $deckId = $deck->getId();

        if (!$cardId || !$deckId) {
            return $this->json(['status' => 'No card found in deck'], Response::HTTP_NOT_FOUND);
        }

        $deckCard = $deckCardRepository->findOneBy(['deck_id' => $deckId, 'card_id' => $cardId,
        ]);

        $em = $this->getDoctrine()->getManager();
        $em->remove($deckCard);
        $em->flush();


        return $this->json(['status' => 'The card was successfully remove from deck.'], Response::HTTP_OK);
    }

    /**
     * @Route("/decks/{name}", name="api_get_decks_card", methods={"GET"})
     */
    public function list(Deck $deck, DeckCardRepository $deckCardRepository, CardRepository $cardRepository)
    {
        $deckId = $deck->getId();

        $deckCards = $deckCardRepository->findBy(['deck_id' => $deckId]);

        $power = 0;
        foreach ($deckCards as $deckCard) {
            $card = $cardRepository->findOneBy(['id' => $deckCard->getCardId()]);
            $power += $card->getPower();
        }

        return $this->json(['power' => $power], Response::HTTP_OK);
    }
}
