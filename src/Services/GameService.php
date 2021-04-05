<?php


namespace App\Services;


use Doctrine\ORM\EntityManagerInterface;

class GameService
{
    /**
     * @var GameBuilder
     */
    private GameBuilder $gameBuilder;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    /**
     * @var Game
     */
    private Game $game;

    public function __construct(GameBuilder $gameBuilder, EntityManagerInterface $entityManager, Game $game)
    {
        $this->gameBuilder = $gameBuilder;
        $this->entityManager = $entityManager;
        $this->game = $game;
    }

    /**
     * @param $host
     * @param $guest
     * @param $numberOfCards
     * @return array|\Exception
     */
    public function play($host, $guest, $numberOfCards)
    {
        try {
            CardFactory::setEntityManager($this->entityManager);

            $this->gameBuilder->setNumberOfCards($numberOfCards);

            $this->gameBuilder->setType('Host');
            $this->gameBuilder->setName($host);
            $this->game->addCard($this->gameBuilder->build());

            $this->gameBuilder->setType('Guest');
            $this->gameBuilder->setName($guest);
            $this->game->addCard($this->gameBuilder->build());

            return $this->game->run();
        } catch (\Exception $e) {
            return $e;
        }
    }
}