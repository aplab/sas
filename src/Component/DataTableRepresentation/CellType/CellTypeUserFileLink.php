<?php namespace App\Component\DataTableRepresentation\CellType;

use App\Util\Path;

class CellTypeUserFileLink extends CellTypeAbstract
{
    public static string $prefix = '/files/';

    public function getValue(object $entity): ?string
    {
        $value = parent::getValue($entity);
        if ($value) {
            $path = new Path(
                static::$prefix,
                $entity->getId(),
                $entity->getName()
            );
            return (string)$path;
        }
        return null;
    }
}
