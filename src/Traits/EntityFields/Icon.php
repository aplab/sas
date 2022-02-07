<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields;


use Doctrine\ORM\Mapping as ORM;

trait Icon
{
    /**
     * @ORM\Column(type="string")
     * @ModuleMetadata\Property(title="Icon",
     *     cell={
     *          @ModuleMetadata\Cell(order=2010, width=220, type="Label"),
     *          @ModuleMetadata\Cell(order=2010, width=80, type="IconVariants", title="Preview")
     *     },
     *     widget={@ModuleMetadata\Widget(order=9000000000, tab="General", type="IconSelector")})
     */
    protected $icon;

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }
}
