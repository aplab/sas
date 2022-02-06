<?php

namespace App\Entity\Site\Form;

use App\Component\ModuleMetadata\Module;
use App\Component\ModuleMetadata\TabDef;
use App\Traits\EntityFields\Site\Form\Order\Active;
use App\Traits\EntityFields\CreatedAtLastModified;
use App\Traits\EntityFields\Id;
use App\Traits\EntityFields\Site\Form\Order\Client;
use App\Traits\EntityFields\Site\Form\Order\Dead;
use App\Traits\EntityFields\Site\Form\Order\Email;
use App\Traits\EntityFields\Site\Form\Order\Messenger;
use App\Traits\EntityFields\Site\Form\Order\Phone;
use App\Traits\EntityFields\Site\Form\Order\Service;
use App\Traits\EntityFields\Site\Form\Order\Viber;
use App\Traits\EntityFields\Site\Form\Order\Whatsapp;
use DateTime;
use Doctrine\ORM\Mapping\Entity;

#[Module(title: 'Форма заявки', tab_order: [
    TabDef::GENERAL => 1000,
    TabDef::TEXT => 2000,
    TabDef::SHORT => 2100,
    TabDef::FULL => 2200,
    TabDef::IMAGE => 1000000,
    TabDef::SEO => 10000000,
    TabDef::ADDITIONAL => 10000418,
])]
#[Entity(repositoryClass: 'App\Repository\Site\Form\OrderFormRepository')]
class OrderForm
{
    use Id;
    use Client;
    use Dead;
    use Phone;
    use Service;
    use Messenger;
    use Email;
    use Whatsapp;
    use Viber;
    use Active;
    use CreatedAtLastModified;

    public function __construct()
    {
        $this->createdAt = new DateTime;
    }
}
