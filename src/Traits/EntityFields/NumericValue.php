<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields;


use Doctrine\ORM\Mapping as ORM;

trait NumericValue
{
    /**
     * @ORM\Column(type="integer")
     * @ModuleMetadata\Property(title="Numeric value",
     *     cell={@ModuleMetadata\Cell(order=2000000, width=120, type="Rtext")},
     *     widget={@ModuleMetadata\Widget(order=2000000, tab="General", type="Text")})
     */
    protected int $numericValue = 0;

    /**
     * @return mixed
     */
    public function getNumericValue(): int
    {
        return $this->numericValue ?? 0;
    }

    /**
     * @param mixed $numericValue
     * @return $this
     */
    public function setNumericValue(int $numericValue): self
    {
        $this->numericValue = (int)$numericValue ?? 0;
        return $this;
    }


}
