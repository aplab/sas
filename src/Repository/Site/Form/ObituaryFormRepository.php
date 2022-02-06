<?php

namespace App\Repository\Site\Form;

use App\Entity\Site\Form\ObituaryForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ObituaryForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method ObituaryForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method ObituaryForm[]    findAll()
 * @method ObituaryForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObituaryFormRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObituaryForm::class);
    }
}
