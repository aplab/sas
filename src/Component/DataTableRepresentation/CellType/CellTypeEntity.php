<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 02.08.2018
 * Time: 10:52
 */

namespace App\Component\DataTableRepresentation\CellType;


class CellTypeEntity extends CellTypeAbstract
{
    public function getValue(object $entity):mixed
    {
        $value = parent::getValue($entity);
        if ($value) {
            $options = $this->cell->getOptions();
            $accessor = $options->accessor ?? 'getName';
            return $value->$accessor();
        }
        return null;
    }
}
