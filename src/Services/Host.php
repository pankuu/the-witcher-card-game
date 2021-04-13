<?php


namespace App\Services;


use Doctrine\ORM\EntityManagerInterface;

/**
 * Class Host
 * @package App\Services
 */
class Host extends AbstractCard implements CardInterface
{
    /**
     * @var string
     */
    protected $type = 'Host';

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
        return $this->powerBonus = rand(-1, 2);
    }
}