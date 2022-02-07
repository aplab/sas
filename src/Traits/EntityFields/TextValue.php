<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields;


use Doctrine\ORM\Mapping as ORM;

trait TextValue
{
    /**
     * @ORM\Column(type="text")
     * @ModuleMetadata\Property(title="Text value",
     *     cell={@ModuleMetadata\Cell(order=3000, width=320, type="TextTooltip")},
     *     widget={@ModuleMetadata\Widget(order=20000, tab="General", type="Textarea")})
     */
    private string $textValue = '';

    /**
     * @return mixed
     */
    public function getTextValue()
    {
        return $this->textValue;
    }

    /**
     * @param mixed $textValue
     * @return $this
     */
    public function setTextValue($textValue)
    {
        $this->textValue = $textValue;
        return $this;
    }
}
