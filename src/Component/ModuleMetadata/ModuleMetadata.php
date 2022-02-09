<?php namespace App\Component\ModuleMetadata;

use ReflectionClass;
use RuntimeException;

class ModuleMetadata
{
    protected string $className;

    public function __construct(ReflectionClass $reflection_class)
    {
        $this->className = $reflection_class->getName();
        $mod_attr = $reflection_class->getAttributes(Module::class);
        if (empty($mod_attr)) {
            throw new RuntimeException('module metadata not found');
        }
        $module_metadata = reset($mod_attr)->newInstance();
        if ($module_metadata instanceof Module) {
            $this->module = $module_metadata;
        } else {
            throw new RuntimeException('unable to instantiate module metadata');
        }
        $properties = $reflection_class->getProperties();
        foreach ($properties as $property) {
            $prop_attr = $property->getAttributes(Property::class);
            if (empty($prop_attr)) {
                continue;
            }
            $property_metadata = reset($prop_attr)->newInstance();
            if ($property_metadata instanceof Property) {
                $this->properties[$property->getName()] = $property_metadata;
            } else {
                throw new RuntimeException('unable to instantiate property metadata');
            }
            $cell_attr = $property->getAttributes(Cell::class);
            $cells = [];
            foreach ($cell_attr as $ca) {
                $cells[] = $ca->newInstance();
            }
            $property_metadata->setCell(...$cells);
            
            $widget_attr = $property->getAttributes(Widget::class);
            $widgets = [];
            foreach ($widget_attr as $ca) {
                $widgets[] = $ca->newInstance();
            }
            $property_metadata->setWidget(...$widgets);
        }
    }

    protected Module $module;

    /** @var Property[] */
    protected array $properties;

    public function getClassName(): string
    {
        return $this->className;
    }

    public function getModule(): Module
    {
        return $this->module;
    }

    public function setModule(Module $module): static
    {
        $this->module = $module;
        return $this;
    }

    /** @return Property[] */
    public function getProperties(): array
    {
        return $this->properties;
    }

    public function setProperties(Property ...$properties): static
    {
        $this->properties = $properties;
        return $this;
    }
}
