<?php

namespace App\Repository\Site\Form;

use App\Entity\Site\Form\OrderForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderForm[]    findAll()
 * @method OrderForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderFormRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderForm::class);
    }
}
