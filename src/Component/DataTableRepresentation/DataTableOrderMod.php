<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 09.09.2018
 * Time: 11:53
 */

namespace App\Component\DataTableRepresentation;


class DataTableOrderMod extends DataTable
{
    /**
     * Temporary stub
     * @return object[]
     */
    public function getItems()
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
