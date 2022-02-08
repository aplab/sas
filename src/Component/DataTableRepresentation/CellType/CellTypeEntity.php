<?php namespace App\Component\DataTableRepresentation\CellType;

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
