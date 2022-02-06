<?php namespace App\Entity;

use App\Component\ModuleMetadata\Module;
use App\Traits\EntityFields\CreatedAtLastModified;
use App\Traits\EntityFields\Id;
use App\Traits\EntityFields\Name;
use App\Traits\EntityFields\Text;
use DateTime;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

#[Module(title: 'Named timestampable', description: 'Named timestampable entity', tab_order: [
    'General' => 1000,
    'Text' => 2000,
    'Additional' => 10000418
])]
#[Entity(repositoryClass: 'App\Repository\NamedTimestampableRepository')]
#[Table(name: 'named_timestampable')]
class NamedTimestampable
{
    public function __construct()
    {
        $this->createdAt = new DateTime;
    }

    use Id, Name, Text, CreatedAtLastModified;
}
