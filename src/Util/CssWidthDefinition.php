<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 20.08.2018
 * Time: 22:39
 */

namespace App\Util;


class CssWidthDefinition
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var int
     */
    private $sum = 0;

    /**
     * CssWidthDefinition constructor.
     */
    public function __construct()
    {
        $this->data = [];
    }

    /**
     * @param int $width
     * @return CssWidthDefinition
     */
    public function add(int $width): static
    {
        $this->sum += $width;
        $this->data[$width] = $width;
        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array_values($this->data);
    }

    /**
     * @return int
     */
    public function getSum(): int
    {
        return $this->sum;
    }
}
