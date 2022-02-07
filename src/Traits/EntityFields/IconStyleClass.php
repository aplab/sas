<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields;


use Doctrine\ORM\Mapping as ORM;

trait IconStyleClass
{
    /**
     * @ORM\Column(type="string")
     * @ModuleMetadata\Property(title="Icon style class",
     *     cell={
     *          @ModuleMetadata\Cell(order=2010, width=220, type="Label"),
     *          @ModuleMetadata\Cell(order=2010, width=80, type="IconVariants")
     *     },
     *     widget={@ModuleMetadata\Widget(order=9000000000, tab="Additional", type="Text")})
     */
    protected $iconStyleClass;

    /**
     * @return mixed
     */
    public function getIconStyleClass()
    {
        return $this->iconStyleClass;
    }

    /**
     * @param mixed $iconStyleClass
     * @return $this
     */
    public function setIconStyleClass($iconStyleClass)
    {
        $this->iconStyleClass = $iconStyleClass;
        return $this;
    }
}
