<?php

namespace App\Repository;

use App\Entity\Icon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Icon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Icon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Icon[]    findAll()
 * @method Icon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IconRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Icon::class);
    }

    public function getOptionsDataList($selected = null): array
    {
        $items = $this->findBy([], ['name' => 'ASC']);
        $data = [];
        foreach ($items as $item) {
            $sc = $item->getIconStyleClass();
            $data[] = [
                'value' => $sc,
                'text' => $item->getName(),
                'selected' => $sc === $selected,
            ];
        }
        return $data;
    }
}
