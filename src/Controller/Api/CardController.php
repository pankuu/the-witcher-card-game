<?php


namespace App\Controller\Api;


use App\Entity\Card;
use App\Helper\CardValidate;
use App\Repository\CardRepository;
use App\Services\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CardController
 * @package App\Controller\Api
 * @Route("/api", name="api_")
 */
class CardController extends AbstractController
{
    /**
     * @Route("/cards", name="create_card", methods={"POST"})
     * @param Request $request
     * @param CardValidate $cardValidate
     * @return JsonResponse
     */
    public function create(Request $request, CardValidate $cardValidate): JsonResponse
    {
        $title = $request->get('title');
        $power = $request->get('power');

        $errors = $cardValidate->postValidate($title, $power);

        if($errors) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $card = new Card();
        $card->setTitle($title);
        $card->setPower($power);
        $card->setIsBlocked(false);

        $em = $this->getDoctrine()->getManager();
        $em->persist($card);
        $em->flush();

        return $this->json(['status' => 'Card successfully added.'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/cards/{title}", name="remove_card", methods={"DELETE"}, requirements={"id":"\d+"})
     * @param Card $card
     * @return JsonResponse
     */
    public function remove(Card $card): JsonResponse
    {
        if (!$card) {
            return $this->json(['status' => 'Not found.'], Response::HTTP_NOT_FOUND);
        }

        if ($card->getIsBlocked()) {
            return $this->json(['status' => 'The super card cannot be deleted.'], Response::HTTP_OK);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($card);
        $em->flush();

        return $this->json(['status' => 'The card was successfully deleted.'], Response::HTTP_OK);
    }

    /**
     * @Route("/cards/{title}", name="update_card", methods={"PATCH"})
     * @param Card $card
     * @param Request $request
     * @param CardValidate $cardValidate
     * @return JsonResponse
     */
    public function update(Card $card, Request $request, CardValidate $cardValidate): JsonResponse
    {
        $title = $request->get('title');
        $power = $request->get('power');

        if ($card->getIsBlocked() === true) {
            return $this->json(['status' => 'The super card cannot be edited.'], Response::HTTP_OK);
        }

        $errors = $cardValidate->patchValidate($title, $power);

        if($errors) {
            return $this->json($errors, Response::HTTP_NOT_FOUND);
        }

        empty($title) ? true : $card->setTitle($title);
        empty($power) ? true : $card->setPower($power);

        $em = $this->getDoctrine()->getManager();
        $em->persist($card);
        $em->flush();

        return $this->json(['status' => 'Updated successfully'], Response::HTTP_OK);
    }

    /**
     * @Route("/cards", name="list_card", methods={"GET"})
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return JsonResponse
     */
    public function list(Request $request, CardRepository $cardRepository, PaginatorInterface $paginator): JsonResponse
    {
        $queryBuilder = $cardRepository->getAtLestBlockedCardQueryBuilder(true);

        $results = $paginator->paginate($queryBuilder, $request, 3);

        $data = [
            'status' => "Successfully fetched list",
            'data' => $results,
            'links' => [
                'previous_page' => "?page={$paginator->previousPage($results, $request)}",
                'next_page' => "?page={$paginator->nextPage($results, $request)}",
                'last_page' => "?page={$paginator->lastPage($results)}",
                'total_items' => "{$paginator->total($results)}"
            ]
        ];

        return $this->json($data);
    }
}