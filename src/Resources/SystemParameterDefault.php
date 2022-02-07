<?php declare(strict_types=1);


namespace App\Resources;


use App\Entity\SystemParameter;

class SystemParameterDefault
{
    /* @return SystemParameter[] */
    public static function get(): array {
        return [
            (new SystemParameter())->setToken('DEFAULT_HTML_TITLE')->setStringValue('Default HTML Title'),
            (new SystemParameter())->setToken('DEFAULT_META_DESCRIPTION')->setStringValue('Default meta description'),
            (new SystemParameter())->setToken('DEFAULT_META_KEYWORDS')->setStringValue('Default meta keywords'),
            (new SystemParameter())->setToken('DESKTOP_CSS')->setStringValue('background: #393F4C url(\'/capsule/assets/cms/login/banner.jpg\') no-repeat center center; background-size: cover;'),
        ];
    }

    private function __construct() {}
}