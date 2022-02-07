<?php

namespace App\Repository;

use App\Entity\DesktopEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DesktopEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method DesktopEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method DesktopEntry[]    findAll()
 * @method DesktopEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DesktopEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DesktopEntry::class);
    }
}
