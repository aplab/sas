<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields;


use Doctrine\ORM\Mapping as ORM;

trait StringValue
{
    /**
     * @ORM\Column(type="string")
     * @ModuleMetadata\Property(title="String value",
     *     cell={@ModuleMetadata\Cell(order=2000, width=320, type="TextTooltip")},
     *     widget={@ModuleMetadata\Widget(order=2000, tab="General", type="Text")})
     */
    protected string $stringValue = '';

    /**
     * @return string
     */
    public function getStringValue(): string
    {
        return $this->stringValue;
    }

    /**
     * @param mixed $stringValue
     * @return self
     */
    public function setStringValue($stringValue): self
    {
        $this->stringValue = $stringValue;
        return $this;
    }
}
