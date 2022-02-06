<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 02.08.2018
 * Time: 10:57
 */

namespace App\Component\InstanceEditor;

use App\Component\InstanceEditor\FieldType\FieldTypeInterface;
use App\Component\ModuleMetadata\Options;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\Widget;
use ReflectionProperty;

class InstanceEditorField
{
    private InstanceEditor $instanceEditor;
    private object $entity;
    private string $propertyName;
    private string $title;
    private string $label;
    private string $comment;
    private string $help;
    private int $order;
    private mixed $type;
    private Options $options;
    private string $tab;

    public function __construct(InstanceEditor $instance_editor, ReflectionProperty $property,
                                Property $property_metadata, Widget $widget_metadata)
    {
        $this->instanceEditor = $instance_editor;
        $this->propertyName = $property->getName();
        $title = $widget_metadata->getTitle();
        if ($title) {
            $this->title = $title;
        } else {
            $this->title = $property_metadata->getTitle();
        }
        $this->label = $widget_metadata->getLabel();
        $this->comment = $widget_metadata->getComment();
        $this->help = $widget_metadata->getHelp();
        $this->order = $widget_metadata->getOrder();
        $this->type = new ($widget_metadata->getType())($this);
        $this->options = $widget_metadata->getOptions();
        $this->tab = $widget_metadata->getTab();
        $this->entity = $instance_editor->getEntity();
    }

    public function getPropertyName(): string
    {
        return $this->propertyName;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function getType(): FieldTypeInterface
    {
        return $this->type;
    }

    public function getOptions(): ?Options
    {
        return $this->options;
    }

    public function getTab(): string
    {
        return $this->tab;
    }

    public function getInstanceEditor(): InstanceEditor
    {
        return $this->instanceEditor;
    }

    public function getEntity(): object
    {
        return $this->entity;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getHelp(): string
    {
        return $this->help;
    }
}
