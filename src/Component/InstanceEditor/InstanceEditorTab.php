<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 02.08.2018
 * Time: 10:57
 */

namespace App\Component\InstanceEditor;


use LogicException;

class InstanceEditorTab
{
    protected string $name;
    protected int $order;

    /** @var array<InstanceEditorField> */
    protected array $field;

    public function __construct()
    {
        $this->field = [];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): InstanceEditorTab
    {
        $this->name = $name;
        return $this;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function setOrder(int $order): InstanceEditorTab
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return InstanceEditorField[]
     */
    public function getField(): array
    {
        return $this->field;
    }

    public function addField(InstanceEditorField $field): InstanceEditorTab
    {
        if ('ckeditor' === $field->getType()->getType()) {
            if (sizeof($this->field)) {
                throw new LogicException('CKEditor field type requires a separate group. Check configuration.');
            }
            $this->setCkeditor();
        }
        $this->field[] = $field;
        usort($this->field, function (InstanceEditorField $a, InstanceEditorField $b) {
            return $a->getOrder() <=> $b->getOrder();
        });
        return $this;
    }

    protected bool $ckeditor = false;

    public function getCkeditor(): bool
    {
        return $this->ckeditor;
    }

    public function setCkeditor(bool $ckeditor = true): InstanceEditorTab
    {
        $this->ckeditor = $ckeditor;
        return $this;
    }
}
