<?php

namespace App\Repository\Site\Form;

use App\Entity\Site\Form\FeedbackForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FeedbackForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method FeedbackForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method FeedbackForm[]    findAll()
 * @method FeedbackForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeedbackFormRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FeedbackForm::class);
    }
}
