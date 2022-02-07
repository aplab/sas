<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields;


use Doctrine\ORM\Mapping as ORM;

trait StdInt
{
    /**
     * @ORM\Column(type="bigint")
     * @ModuleMetadata\Property(title="Sort order",
     *     cell={@ModuleMetadata\Cell(order=2000000, width=120, type="Rtext")},
     *     widget={@ModuleMetadata\Widget(order=2000000, tab="General", type="Text")})
     */
    protected int $stdInt = 0;

    /**
     * @return mixed
     */
    public function getStdInt()
    {
        return $this->stdInt ?? 0;
    }

    /**
     * @param mixed $stdInt
     * @return $this
     */
    public function setStdInt($stdInt)
    {
        $this->stdInt = $stdInt ?? 0;
        return $this;
    }


}
