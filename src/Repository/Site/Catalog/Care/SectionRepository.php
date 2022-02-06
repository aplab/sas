<?php

namespace App\Repository\Site\Catalog\Care;

use App\Entity\Site\Catalog\Care\Section;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Section|null find($id, $lockMode = null, $lockVersion = null)
 * @method Section|null findOneBy(array $criteria, array $orderBy = null)
 * @method Section[]    findAll()
 * @method Section[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Section::class);
    }

    /**
     * @param null $selected
     * @return array|mixed
     */
    public function getOptionsDataList($selected = null)
    {
        $tmp = $this->findAll();
        array_walk($tmp, function ($v, $k) use (& $tmp, $selected) {
            $tmp[$k] = array(
                'value' => $v->getId(),
                'text' => $v->getName(),
                'selected' => $v === $selected
            );
        });
        return $tmp;
    }
}
