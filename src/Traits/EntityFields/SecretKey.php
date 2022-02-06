<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields;


use App\Component\InstanceEditor\FieldType\FieldTypeTextareaDouble;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;
use Exception;
use Throwable;

trait SecretKey
{
    #[Property(title: 'Secret key')]
    #[Widget(type: FieldTypeTextareaDouble::class, order: 2000, tab: TabDef::SECURITY)]
    #[Column(type: 'binary', length: 255, nullable: true)]
    protected mixed $secretKey = null;

    public function getSecretKey(): string
    {
        if (is_resource($this->secretKey)) {
            $this->secretKey = stream_get_contents($this->secretKey);
        }
        return bin2hex($this->secretKey);
    }

    /**
     * Сгенерировать новый ключ
     * @throws Exception
     */
    public function newSecretKey(): string
    {
        $this->secretKey = random_bytes(240) . date('YmdHis', strtotime('+1 day'));
        return bin2hex($this->secretKey);
    }

    public function checkSecretKey(string $key): bool
    {
        $original = $this->getSecretKey();
        if ($original !== $key) {
            return false;
        }
        try {
            $bin = hex2bin($original);
            if (false === $bin) {
                return false;
            }
            $expired = strtotime(substr($bin, -14, 14));
            if (false === $expired) {
                return false;
            }
        } catch (Throwable $exception) {
            return false;
        }
        return $expired > time();
    }
}
