<?php namespace App\Component\InstanceEditor\FieldType;

use App\Component\InstanceEditor\InstanceEditorField;
use LogicException;

abstract class FieldTypeAbstract implements FieldTypeInterface
{
    const PREFIX = 'FieldType';

    protected InstanceEditorField $field;
    protected string $type;

    public function __construct(InstanceEditorField $field)
    {
        $tmp = explode(self::PREFIX, static::class);
        $this->type = strtolower(end($tmp));
        $this->field = $field;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /** @noinspection SpellCheckingInspection */
    public function getValue(): mixed
    {
        /** @noinspection DuplicatedCode */
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
        throw new LogicException('unable to access property ' . get_class($entity) . '::' . $property_name);
    }

    public function getUniqueId(): string
    {
        return spl_object_id($this);
    }

    public function getField(): InstanceEditorField
    {
        return $this->field;
    }

    public function getOptionsDataList(): array
    {
        throw new \RuntimeException('method not allowed');
    }

    public function getEntityClass(): string
    {
        throw new \RuntimeException('method not allowed');
    }
}
