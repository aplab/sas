<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 02.08.2018
 * Time: 10:59
 */

namespace App\Component\InstanceEditor\FieldType;


use App\Component\InstanceEditor\InstanceEditorField;

class FieldTypeEntityId extends FieldTypeAbstract
{
    protected ?string $entityClass = null;

    public function getOptionsDataList()
    {
        $em = $this->field->getInstanceEditor()->getEntityManagerInterface();
        $repository = $em->getRepository($this->getEntityClass());
        $value = $this->getValue();
        return $repository->getOptionsDataList($value);
    }

    public function getField(): InstanceEditorField
    {
        return $this->field;
    }

    public function getEntityClass(): string
    {
        if (is_null($this->entityClass)) {
            $this->entityClass = $this->getField()->getOptions()->data_class ?? get_class($this->field->getEntity());
        }
        return $this->entityClass;
    }
}
