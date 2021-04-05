<?php


namespace App\Services;


use App\Entity\Deck;
use App\Entity\DeckCard;

abstract class AbstractCard implements Card, Observer
{
    protected $card = [];
    protected $cardPower;
    protected $name;
    protected $type;
    protected $power;
    protected $drawCards = [];
    protected $cards = [];
    protected $powerBonus;
    protected $numberOfCards;
    private $entityManager;


    public function __construct(string $name, $numberOfCards, $entityManager)
    {
        $this->name = $name;
        $this->numberOfCards = $numberOfCards;
        $this->entityManager = $entityManager;
    }

    public function drawCards(): void
    {
        $cards = $this->drawCards;

        if ($this->numberOfCards > 1) {
            $rand = array_rand($cards, $this->numberOfCards);
            $flip = array_flip($rand);
            $cards = array_intersect_key($cards, $flip);
        }

        foreach ($cards as $card) {
            $this->cards[] = $card->getCardId();
        }
    }

    /**
     * @throws \Exception
     */
    public function getCards(): void
    {
        $deck = $this->entityManager->getRepository(Deck::class)->findOneBy(['name' => $this->name]);

        if (!$deck) {
            throw new \Exception('Deck does not exists. Choose one more time.');
        }

        $this->drawCards = $this->entityManager->getRepository(DeckCard::class)->findBy(['deck_id' => $deck->getId()]);
    }

    /**
     * @param string $event
     * @return array
     * @throws \Exception
     */
    public function notify(string $event): array
    {
        if ($event === 'nextTurn') {
            $this->move();
        }

        return [
            $this->name => [
                'powerSum' => $this->power,
                'cards' => $this->card,
                'bonus' => $this->getPowerBonus()
            ]
        ];
    }

    /**
     * @throws \Exception
     */
    public function move(): void
    {
        $this->preMove();

        foreach ($this->cards as $card) {
            $this->getCard($card);
            $this->getPowerCard();
        }
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getPowerBonus(): int
    {
        return $this->powerBonus;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @throws \Exception
     */
    protected function preMove()
    {
        $this->getCards();
        $this->drawCards();
    }

    public function getCard($id): void
    {
        $card = $this->entityManager->getRepository(\App\Entity\Card::class)->findOneBy(['id' => $id]);
        $this->cardPower = $card->getPower();
        $this->card[] = [
            'title' => $card->getTitle(),
            'power' => $card->getPower()
        ];
    }

    protected function getPowerCard(): void
    {
        $this->power += $this->cardPower + $this->getPowerBonus();
    }
}