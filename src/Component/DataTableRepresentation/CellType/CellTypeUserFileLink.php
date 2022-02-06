<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 05.09.2018
 * Time: 23:12
 */

namespace App\Component\DataTableRepresentation\CellType;


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
