<?php

namespace App\Entity\Site;

use _PHPStan_76800bfb5\Nette\Utils\DateTime;
use App\Component\ModuleMetadata\Module;
use App\Component\ModuleMetadata\TabDef;
use App\Repository\Site\FileRepository;
use App\Traits\EntityFields\Id;
use App\Traits\EntityFields\Site\File\BurialId;
use App\Traits\EntityFields\Site\File\Created;
use App\Traits\EntityFields\Site\File\Filename;
use App\Traits\EntityFields\Site\File\Latitude;
use App\Traits\EntityFields\Site\File\Longitude;
use App\Traits\EntityFields\Site\File\Module as Mod;
use App\Traits\EntityFields\Site\File\Type;
use App\Traits\EntityFields\Site\File\UserId;
use Doctrine\ORM\Mapping\Entity;

#[Module(title: 'File', tab_order: [
    TabDef::GENERAL => 1000,
    TabDef::TEXT => 2000,
    TabDef::SHORT => 2100,
    TabDef::FULL => 2200,
    TabDef::IMAGE => 1000000,
    TabDef::SEO => 10000000,
    TabDef::ADDITIONAL => 100000000418,
    TabDef::SECURITY => 10000518,
    TabDef::MAP => 10000618,
])]
#[Entity(repositoryClass: FileRepository::class)]
class File
{
    use Id, Filename, Mod, Type, Latitude, Longitude, BurialId, UserId, Created;

    public function __construct()
    {
        $this->created = new DateTime;
    }
}
