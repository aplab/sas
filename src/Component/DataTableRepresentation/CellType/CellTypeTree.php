<?php namespace App\Component\DataTableRepresentation\CellType;

class CellTypeTree extends CellTypeAbstract
{
    public function getValue(object $entity): mixed
    {
        $value = parent::getValue($entity);
        if ($value) {
            return $value;
        }
        return null;
    }

    public function getPrefix($entity): string
    {
        $level = $entity->level ?? 0;
        return str_repeat(html_entity_decode('&bull;&nbsp;'), $level);
    }
}
