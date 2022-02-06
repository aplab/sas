<?php namespace App\Entity\Site\Form;

use App\Component\ModuleMetadata\Module;
use App\Component\ModuleMetadata\TabDef;
use App\Traits\EntityFields\CreatedAtLastModified;
use App\Traits\EntityFields\Id;
use App\Traits\EntityFields\Site\Form\Obituary\Active;
use App\Traits\EntityFields\Site\Form\Obituary\Dead;
use App\Traits\EntityFields\Site\Form\Obituary\Email;
use App\Traits\EntityFields\Site\Form\Obituary\Obituary;
use DateTime;
use Doctrine\ORM\Mapping\Entity;

#[Module(title: 'Форма некролог', tab_order: [
    TabDef::GENERAL => 1000,
    TabDef::TEXT => 2000,
    TabDef::SHORT => 2100,
    TabDef::FULL => 2200,
    TabDef::IMAGE => 1000000,
    TabDef::SEO => 10000000,
    TabDef::ADDITIONAL => 10000418,
])]
#[Entity(repositoryClass: 'App\Repository\Site\Form\ObituaryFormRepository')]
class ObituaryForm
{
    use Id;
    use Dead;
    use Email;
    use Obituary;
    use Active;
    use CreatedAtLastModified;

    public function __construct()
    {
        $this->createdAt = new DateTime;
    }
}
