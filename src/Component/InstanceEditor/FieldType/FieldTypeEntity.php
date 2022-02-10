<?php namespace App\Component\InstanceEditor\FieldType;

use App\Component\InstanceEditor\InstanceEditorField;
use LogicException;

class FieldTypeEntity extends FieldTypeAbstract
{
    protected ?string $entityClass = null;

    public function getValue(): mixed
    {
        /** @noinspection DuplicatedCode */
        $entity = $this->field->getEntity();
        $property_name = $this->field->getPropertyName();
        $property_name_ucfirst = ucfirst($property_name);
        /** @noinspection SpellCheckingInspection */
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

    public function getOptionsDataList(): array
    {
        $em = $this->field->getInstanceEditor()->getEntityManagerInterface();
        $repository = $em->getRepository($this->getEntityClass());
        $value = $this->getValue();
        return $repository->getOptionsDataList($value);
    }

    public function getEntityClass(): string
    {
        if (is_null($this->entityClass)) {
            $this->entityClass = $this->getField()->getOptions()->data_class ?? get_class($this->field->getEntity());
        }
        return $this->entityClass;
    }
}
