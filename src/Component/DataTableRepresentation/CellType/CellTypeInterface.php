<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 02.08.2018
 * Time: 10:48
 */

namespace App\Component\DataTableRepresentation\CellType;


interface CellTypeInterface
{
    public function getType();

    public function getValue(object $entity);

    public function getUniqueId();

    public function getClass(mixed $entity);
}
