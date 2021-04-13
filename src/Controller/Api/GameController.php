<?php


namespace App\Controller\Api;


use App\Repository\DeckCardRepository;
use App\Repository\DeckRepository;
use App\Services\GameService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GameController
 * @package App\Controller\Api
 * @Route("/api", name="api_")
 */
class GameController extends AbstractController
{
    /**
     * @Route("/games", name="games", methods={"POST"})
     */
    public function play(Request $request, GameService $game, DeckRepository $deckRepository, DeckCardRepository $deckCardRepository): JsonResponse
    {
        $host = $request->get('host');
        $guest = $request->get('guest');
        $numberOfCards = $request->get('numberOfCards');

        if (empty($host) || empty($guest) || empty($numberOfCards)) {
            return $this->json(['status' => 'All data must be set.'], Response::HTTP_BAD_REQUEST);
        }

        $hostDeck = $deckRepository->findOneBy(['name' => $host]);
        $guestDeck = $deckRepository->findOneBy(['name' => $guest]);
        $hostDeckCard = $deckCardRepository->findBy(['deck_id' => $hostDeck->getId()]);
        $guestDeckCard = $deckCardRepository->findBy(['deck_id' => $guestDeck->getId()]);
        $countHostCards = count($hostDeckCard);
        $countGuestCards = count($guestDeckCard);

        if ($countGuestCards < $numberOfCards ||  $countHostCards < $numberOfCards) {
            $maxCard = min($countGuestCards, $countHostCards);
            return $this->json(['status' => "Max cards used for game is: (${maxCard})"]);
        }

        $match = $game->play($host, $guest, $numberOfCards);

        if ($match instanceof \Exception) {
            return $this->json(['status' => $match->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return $this->json($match);
    }
}
