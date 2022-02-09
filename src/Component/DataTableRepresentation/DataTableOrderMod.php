<?php namespace App\Component\DataTableRepresentation;

class DataTableOrderMod extends DataTable
{
    /**
     * Temporary stub
     * @return object[]
     */
    public function getItems(): array
    {
        $pager = $this->getPager();
        return $this->entityManager->getRepository($this->entityClassName)->findBy(
            [],
            ['sortOrder' => 'ASC', 'id' => 'ASC'],
            $pager->getItemsPerPage(),
            $pager->getOffset()
        );
    }
}
