<?php

namespace App\Entity\Site;

use App\Component\ModuleMetadata\Module;
use App\Component\ModuleMetadata\TabDef;
use App\Traits\EntityFields\Active;
use App\Traits\EntityFields\Code;
use App\Traits\EntityFields\CreatedAtLastModified;
use App\Traits\EntityFields\Id;
use App\Traits\EntityFields\Name;
use App\Traits\EntityFields\Seo;
use App\Traits\EntityFields\Text;
use DateTime;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Index;

#[Module(title: 'Текстовый блок', tab_order: [
    TabDef::GENERAL => 1000,
    TabDef::TEXT => 2000,
    TabDef::SHORT => 2100,
    TabDef::FULL => 2200,
    TabDef::IMAGE => 1000000,
    TabDef::SEO => 10000000,
    TabDef::ADDITIONAL => 10000418,
])]
#[Entity(repositoryClass: 'App\Repository\Site\TextBlockRepository')]
#[Index(columns: ['code'], name: 'code')]
class TextBlock
{
    use Id;
    use Name;
    use Text;
    use Active;
    use CreatedAtLastModified;
    use Seo;
    use Code;

    public function __construct()
    {
        $this->createdAt = new DateTime;
    }
}
