<?php

namespace App\Repository;

use App\Entity\DeckCard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DeckCard|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeckCard|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeckCard[]    findAll()
 * @method DeckCard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeckCardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeckCard::class);
    }

    public function remove($cardId): void
    {
        $qb = $this->createQueryBuilder('dc')
            ->delete('App:DeckCard', 'dc')
            ->andWhere('dc.card_id = :cardId')
            ->setParameter('cardId', $cardId);

        $qb->getQuery()->execute();
    }

    // /**
    //  * @return DeckCard[] Returns an array of DeckCard objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DeckCard
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
