<?php namespace App\Component\DataTableRepresentation\CellType;

use App\Component\DataTableRepresentation\DataTableCell;
use LogicException;

abstract class CellTypeAbstract implements CellTypeInterface
{
    const PREFIX = 'CellType';

    public function __construct(DataTableCell $cell)
    {
        $tmp = explode(self::PREFIX, static::class);
        $this->type = strtolower(end($tmp));
        $this->cell = $cell;
    }

    protected string $type;

    protected DataTableCell $cell;

    public function getType(): string
    {
        return $this->type;
    }

    public function getUniqueId(): string
    {
        return spl_object_id($this);
    }

    /** @noinspection SpellCheckingInspection */
    public function getValue(object $entity): mixed
    {
        $property_name = $this->cell->getPropertyName();
        $property_name_ucfirst = ucfirst($property_name);
        $accessors = [
            'getter' => 'get' . $property_name_ucfirst,
            'isser' => 'is' . $property_name_ucfirst,
            'hasser' => 'has' . $property_name_ucfirst
        ];
        foreach ($accessors as $accessor) {
            if (method_exists($entity, $accessor)) {
                return $entity->$accessor();
            }
        }
        throw new LogicException('unable to access property ' . get_class($entity) . '::' . $property_name);
    }

    public function getClass(mixed $entity): string
    {
        return get_class($entity);
    }
}
