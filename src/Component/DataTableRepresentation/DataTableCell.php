<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 02.08.2018
 * Time: 10:46
 */

namespace App\Component\DataTableRepresentation;


use App\Component\DataTableRepresentation\CellType\CellTypeInterface;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Options;
use App\Component\ModuleMetadata\Property;
use ReflectionProperty;

class DataTableCell
{
    private DataTable $dataTable;

    /**
     * @var string
     */
    private $propertyName;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $comment;

    /**
     * @var string
     */
    private $help;

    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $order;

    /**
     * @var CellTypeInterface
     */
    private $type;

    /**
     * @var Options
     */
    private $options;

    public function __construct(DataTable $data_table, ReflectionProperty $property, Property $property_metadata,
                                Cell $cell_metadata)
    {
        $this->dataTable = $data_table;
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

    /**
     * @return string
     */
    public function getPropertyName(): string
    {
        return $this->propertyName;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @return CellTypeInterface
     */
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
