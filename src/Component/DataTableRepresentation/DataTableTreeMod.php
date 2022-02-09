<?php namespace App\Component\DataTableRepresentation;

class DataTableTreeMod extends DataTable
{
    public function getCount(): int
    {
        if (is_null($this->count)) {
            $this->count = $this->entityManager->getRepository($this->entityClassName)->getRootsCount([]);
        }
        return $this->count;
    }

    /**
     * Temporary stub
     * @return object[]
     */
    public function getItems(): array
    {
        $pager = $this->getPager();
        return $this->entityManager->getRepository($this->entityClassName)->rootPage(
            $pager->getItemsPerPage(),
            $pager->getOffset()
        );
    }
}
