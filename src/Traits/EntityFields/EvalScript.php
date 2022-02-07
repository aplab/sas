<?php


namespace App\Traits\EntityFields;


use App\Component\InstanceEditor\FieldType\FieldTypeTextareaCodemirror;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait EvalScript
{
    #[Property(title: 'Eval script')]
    #[Widget(type: FieldTypeTextareaCodemirror::class, order: 20000, tab: TabDef::ADDITIONAL)]
    #[Column(type: 'text')]
    private string $evalScript = '';

    public function getEvalScript()
    {
        return $this->evalScript;
    }

    public function setEvalScript($evalScript)
    {
        $this->evalScript = trim($evalScript);
        return $this;
    }
}
