<?php

namespace App\Repository;

use App\Entity\SystemParameter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SystemParameter|null find($id, $lockMode = null, $lockVersion = null)
 * @method SystemParameter|null findOneBy(array $criteria, array $orderBy = null)
 * @method SystemParameter[]    findAll()
 * @method SystemParameter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SystemParameterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SystemParameter::class);
    }

    /**
     * @param string ...$token
     * @return SystemParameter[]
     */
    public function findByToken(string...$token): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.token IN(:token)')
            ->setParameter('token', $token)
            ->getQuery()
            ->getResult();
    }
}
