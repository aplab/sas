<?php

namespace App\Repository\Site\Cemetery;

use App\Entity\Site\Cemetery\Cemetery;
use App\Entity\Site\City;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cemetery|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cemetery|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cemetery[]    findAll()
 * @method Cemetery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CemeteryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cemetery::class);
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

    /**
     * @return Cemetery[] Returns an array of Comment objects
     */
    public function findByCity(City $value): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.cityId = :val')
            ->setParameter('val', $value->getId())
            ->orderBy('c.name', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
}
