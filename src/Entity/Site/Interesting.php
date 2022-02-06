<?php

namespace App\Entity\Site;

use App\Component\DataTableRepresentation\CellType\CellTypeEntity;
use App\Component\InstanceEditor\FieldType\FieldTypeEntity;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Module;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use App\Traits\EntityFields\Active;
use App\Traits\EntityFields\CreatedAtLastModified;
use App\Traits\EntityFields\Id;
use App\Traits\EntityFields\Image1;
use App\Traits\EntityFields\Image2;
use App\Traits\EntityFields\Name;
use App\Traits\EntityFields\PublicationDatetime;
use App\Traits\EntityFields\Seo;
use App\Traits\EntityFields\Source;
use App\Traits\EntityFields\SourceUrl;
use App\Traits\EntityFields\Text1;
use App\Traits\EntityFields\Text2;
use DateTime;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[Module(title: 'Interesting', tab_order: [
    'General' => 1000,
    'Text' => 2000,
    'Short' => 2100,
    'Full' => 2200,
    'Image' => 1000000,
    'SEO' => 10000000,
    'Additional' => 10000418
])]
#[Entity(repositoryClass: 'App\Repository\Site\InterestingRepository')]
#[Index(columns: ["publication_datetime"], name: "publication_datetime")]
#[Index(columns: ["active", "section_id", "publication_datetime"], name: "active_section_pubdatetime")]
#[Index(columns: ["active"], name: "active")]
class Interesting
{
    use Id;
    use Name;
    use PublicationDatetime;
    use Image1;
    use Image2;
    use Text1;
    use Text2;
    use Active;
    use CreatedAtLastModified;
    use Seo;
    use Source;
    use SourceUrl;

    #[Property(title: 'Section')]
    #[Cell(type: CellTypeEntity::class, order: 3000, width: 320, options: ['accessor'=>'getName'])]
    #[Widget(type: FieldTypeEntity::class, order: 2000, tab: TabDef::GENERAL, options: ['data_class'=>Section::class])]
    #[ManyToOne(targetEntity: 'App\Entity\Site\Section', fetch: 'EAGER', inversedBy: 'interesting')]
    #[JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private $section;

    public function __construct()
    {
        $this->createdAt = new DateTime;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): static
    {
        $this->section = $section;

        return $this;
    }
}
