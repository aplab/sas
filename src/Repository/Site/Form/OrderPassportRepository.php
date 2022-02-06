<?php

namespace App\Repository\Site\Form;

use App\Entity\Site\Form\OrderPassport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderPassport|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderPassport|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderPassport[]    findAll()
 * @method OrderPassport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderPassportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderPassport::class);
    }
}
