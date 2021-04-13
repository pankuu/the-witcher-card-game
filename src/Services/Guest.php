<?php


namespace App\Services;


use Doctrine\ORM\EntityManagerInterface;

class Guest extends AbstractCard implements CardInterface
{
    /**
     * @var string
     */
    protected $type = 'Guest';

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct($name, $numberOfCards, EntityManagerInterface $entityManager)
    {
        parent::__construct($name, $numberOfCards, $entityManager);
        $this->entityManager = $entityManager;
    }

    /**
     * @return int
     */
    public function getPowerBonus(): int
    {
        return $this->powerBonus = rand(-1, 1);
    }
}
