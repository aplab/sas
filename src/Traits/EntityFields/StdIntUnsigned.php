<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields;


use Doctrine\ORM\Mapping as ORM;

trait StdIntUnsigned
{
    /**
     * @ORM\Column(type="bigint", options={"unsigned":true})
     * @ModuleMetadata\Property(title="Sort order",
     *     cell={@ModuleMetadata\Cell(order=2000000, width=120, type="Rtext")},
     *     widget={@ModuleMetadata\Widget(order=2000000, tab="General", type="Text")})
     */
    protected int $stdIntUnsigned = 0;

    /**
     * @return mixed
     */
    public function getStdIntUnsigned()
    {
        return $this->stdIntUnsigned ?? 0;
    }

    /**
     * @param mixed $stdIntUnsigned
     * @return $this
     */
    public function setStdIntUnsigned($stdIntUnsigned)
    {
        $this->stdIntUnsigned = $stdIntUnsigned ?? 0;
        return $this;
    }


}
