<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields;


use Doctrine\ORM\Mapping as ORM;

trait StdString
{
    /**
     * @ORM\Column(type="string")
     * @ModuleMetadata\Property(title="Name",
     *     cell={@ModuleMetadata\Cell(order=2000, width=320, type="Label")},
     *     widget={@ModuleMetadata\Widget(order=2000, tab="General", type="Text")})
     */
    protected string $stdString = '';

    /**
     * @return mixed
     */
    public function getStdString(): string
    {
        return $this->stdString;
    }

    /**
     * @param mixed $stdString
     * @return self
     */
    public function setStdString($stdString): self
    {
        $this->stdString = $stdString;
        return $this;
    }
}
