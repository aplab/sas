<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 02.08.2018
 * Time: 10:59
 */

namespace App\Component\InstanceEditor\FieldType;


use App\Entity\Icon;

class FieldTypeIconSelector extends FieldTypeAbstract
{
    const ICON_CLASS = Icon::class;

    private ?array $iconsData = null;

    public function getOptionsDataList()
    {
        $em = $this->field->getInstanceEditor()->getEntityManagerInterface();
        $repository = $em->getRepository(self::ICON_CLASS);
        $value = $this->getValue();
        return $repository->getOptionsDataList($value);
    }
}
