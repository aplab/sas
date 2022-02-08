<?php namespace App\Component\DataTableRepresentation\CellType;

interface CellTypeInterface
{
    public function getType();

    public function getValue(object $entity);

    public function getUniqueId();

    public function getClass(mixed $entity);
}
