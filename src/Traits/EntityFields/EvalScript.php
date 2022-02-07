<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields;


use Doctrine\ORM\Mapping as ORM;

trait EvalScript
{
    /**
     * @ORM\Column(type="text")
     * @ModuleMetadata\Property(title="Eval script",
     *     cell={},
     *     widget={@ModuleMetadata\Widget(order=20000, tab="Additional", type="TextareaCodemirror")})
     */
    private string $evalScript = '';

    /**
     * @return mixed
     */
    public function getEvalScript()
    {
        return $this->evalScript;
    }

    /**
     * @param mixed $evalScript
     * @return $this
     */
    public function setEvalScript($evalScript)
    {
        $this->evalScript = trim($evalScript);
        return $this;
    }
}
