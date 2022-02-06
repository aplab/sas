<?php

namespace App\Repository\Site;

use App\Entity\Site\City;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method City|null find($id, $lockMode = null, $lockVersion = null)
 * @method City|null findOneBy(array $criteria, array $orderBy = null)
 * @method City[]    findAll()
 * @method City[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, City::class);
    }

    public function getOptionsDataList($selected = null): array
    {
        $tmp = $this->findAll();
        array_walk($tmp, function ($v, $k) use (& $tmp, $selected) {
            $tmp[$k] = array(
                'value' => $v->getId(),
                'text' => $v->getName(),
                'selected' => $v->getId() === (int)$selected
            );
        });
        return $tmp;
    }

    public function findOneByName($value): ?City
    {
        $value = trim(mb_strtolower($value));
        return $this->createQueryBuilder('c')
            ->andWhere('c.name = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
