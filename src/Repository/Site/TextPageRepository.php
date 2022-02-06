<?php

namespace App\Repository\Site;

use App\Entity\Site\TextPage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TextPage|null find($id, $lockMode = null, $lockVersion = null)
 * @method TextPage|null findOneBy(array $criteria, array $orderBy = null)
 * @method TextPage[]    findAll()
 * @method TextPage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TextPageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TextPage::class);
    }

    // /**
    //  * @return TextPage[] Returns an array of TextPage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TextPage
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
