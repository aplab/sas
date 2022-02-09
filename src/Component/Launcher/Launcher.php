<?php

namespace App\Component\Launcher;

use App\Entity\DesktopEntry;
use Doctrine\ORM\EntityManagerInterface;

class Launcher
{
    const DATA_CLASS = DesktopEntry::class;

    private EntityManagerInterface $entityManager;

    private ?array $data = null;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /** @return DesktopEntry[] */
    public function getData(): array
    {
        if (is_null($this->data)) {
            $this->loadData();
        }
        return $this->data;
    }

    private function loadData(): void
    {
        $repo = $this->entityManager->getRepository(self::DATA_CLASS);
        $this->data = $repo->findBy([], ['sortOrder' => 'ASC', 'id' => 'ASC']);
    }
}
