<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields;


use Doctrine\ORM\Mapping as ORM;

trait Url
{
    /**
     * @ORM\Column(type="string")
     * @ModuleMetadata\Property(title="Url",
     *     cell={@ModuleMetadata\Cell(order=2000010, width=200, type="Label")},
     *     widget={@ModuleMetadata\Widget(order=2000010, tab="General", type="RouteVariants")})
     */
    protected $url;

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = trim($url);
        return $this;
    }
}
