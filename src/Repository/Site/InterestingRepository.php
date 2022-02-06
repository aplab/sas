<?php

namespace App\Repository\Site;

use App\Entity\Site\Interesting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Interesting|null find($id, $lockMode = null, $lockVersion = null)
 * @method Interesting|null findOneBy(array $criteria, array $orderBy = null)
 * @method Interesting[]    findAll()
 * @method Interesting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterestingRepository extends ServiceEntityRepository
{
    /**
     * InterestingRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Interesting::class);
    }

    // /**
    //  * @return Interesting[] Returns an array of Interesting objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Interesting
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
