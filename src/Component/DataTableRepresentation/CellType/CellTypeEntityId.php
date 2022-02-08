<?php namespace App\Component\DataTableRepresentation\CellType;

class CellTypeEntityId extends CellTypeAbstract
{
    public function getValue(object $entity): mixed
    {
        $value = parent::getValue($entity);
        if ($value) {
            $options = $this->cell->getOptions();
            $accessor = $options->accessor ?? 'getName';
            /** @noinspection PhpUndefinedFieldInspection */
            $class = $options->data_class;
            $em = $this->cell->getDataTable()->getEntityManager();
            $r = $em->getRepository($class);
            $value = $r->find($value);
            if ($value instanceof $class) {
                return $value->$accessor();
            }
        }
        return null;
    }
}
