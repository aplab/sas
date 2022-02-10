<?php namespace App\Component\InstanceEditor\FieldType;

use App\Component\InstanceEditor\InstanceEditorField;

interface FieldTypeInterface
{
    public function getType(): string;

    public function getValue(): mixed;

    public function getUniqueId(): string;

    public function getField(): InstanceEditorField;

    public function getOptionsDataList(): array;

    public function getEntityClass(): string;
}
