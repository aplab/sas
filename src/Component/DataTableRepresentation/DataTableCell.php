<?php /** @noinspection PhpPropertyOnlyWrittenInspection */ namespace App\Component\DataTableRepresentation;

use App\Component\DataTableRepresentation\CellType\CellTypeInterface;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Options;
use App\Component\ModuleMetadata\Property;
use ReflectionProperty;

class DataTableCell
{
    private DataTable $dataTable;
    private string $propertyName, $title, $label, $comment, $help;
    private int $width, $order;
    private mixed $type;
    private Options $options;

    public function __construct(DataTable $data_table, ReflectionProperty $property, Property $property_metadata,
                                Cell $cell_metadata)
    {
        $this->dataTable = $data_table;
        /** @noinspection DuplicatedCode */
        $this->propertyName = $property->getName();
        $title = $cell_metadata->getTitle();
        if ($title) {
            $this->title = $title;
        } else {
            $this->title = $property_metadata->getTitle();
        }
        $this->label = $cell_metadata->getLabel();
        $this->comment = $cell_metadata->getComment();
        $this->help = $cell_metadata->getHelp();
        $this->width = $cell_metadata->getWidth();
        $this->order = $cell_metadata->getOrder();
        $this->type = new ($cell_metadata->getType())($this);
        $this->options = $cell_metadata->getOptions();
    }

    public function getPropertyName(): string
    {
        return $this->propertyName;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function getType(): CellTypeInterface
    {
        return $this->type;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getOptions(): Options
    {
        return $this->options;
    }

    public function getDataTable(): DataTable
    {
        return $this->dataTable;
    }
}
