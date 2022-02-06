<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 02.08.2018
 * Time: 10:58
 */

namespace App\Component\InstanceEditor\FieldType;


use App\Component\InstanceEditor\InstanceEditorField;
use LogicException;

abstract class FieldTypeAbstract implements FieldTypeInterface
{
    const PREFIX = 'FieldType';
    public function __construct(InstanceEditorField $field)
    {
        $tmp = explode(self::PREFIX, static::class);
        $this->type = strtolower(end($tmp));
        $this->field = $field;
    }

    protected InstanceEditorField $field;
    protected string $type;

    public function getType(): string
    {
        return $this->type;
    }

    public function getValue(): mixed
    {
        $entity = $this->field->getEntity();
        $property_name = $this->field->getPropertyName();
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
        throw new LogicException('Unable to access property ' . get_class($entity) . '::' . $property_name);
    }

    public function getUniqueId(): string
    {
        return spl_object_id($this);
    }
}
