<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields;

use App\Component\InstanceEditor\FieldType\FieldTypeTextarea;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;
use Exception;

trait ActivationKey
{
    #[Property(title: 'Activation key')]
    #[Widget(type: FieldTypeTextarea::class, order: 2000, tab: TabDef::SECURITY)]
    #[Column(type: 'binary', length: 255, nullable: true)]
    protected mixed $activationKey;

    public function getActivationKey(): string
    {
        if (is_resource($this->activationKey)) {
            $this->activationKey = stream_get_contents($this->activationKey);
        }
        return bin2hex($this->activationKey);
    }

    /**
     * Сгенерировать новый ключ активации
     *
     * @param void
     * @return string
     * @throws Exception
     */
    public function newActivationKey(): string
    {
        $this->activationKey = random_bytes(255);
        return bin2hex($this->activationKey);
    }
}
