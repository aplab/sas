<?php

namespace App\Entity\Site\Form;

use App\Component\ModuleMetadata\Module;
use App\Component\ModuleMetadata\TabDef;
use App\Traits\EntityFields\CreatedAtLastModified;
use App\Traits\EntityFields\Id;
use App\Traits\EntityFields\Site\Form\Feedback\Active;
use App\Traits\EntityFields\Site\Form\Feedback\Client;
use App\Traits\EntityFields\Site\Form\Feedback\Message;
use App\Traits\EntityFields\Site\Form\Feedback\Phone;
use DateTime;
use Doctrine\ORM\Mapping\Entity;

#[Module(title: 'Форма обратной связи', tab_order: [
    TabDef::GENERAL => 1000,
    TabDef::TEXT => 2000,
    TabDef::SHORT => 2100,
    TabDef::FULL => 2200,
    TabDef::IMAGE => 1000000,
    TabDef::SEO => 10000000,
    TabDef::ADDITIONAL => 10000418,
])]
#[Entity(repositoryClass: 'App\Repository\Site\Form\FeedbackFormRepository')]
class FeedbackForm
{
    use Id;
    use Client;
    use Phone;
    use Message;
    use Active;
    use CreatedAtLastModified;

    public function __construct()
    {
        $this->createdAt = new DateTime;
    }
}
