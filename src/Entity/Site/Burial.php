<?php /** @noinspection PhpParamsInspection */

namespace App\Entity\Site;

use App\Component\DataTableRepresentation\CellType\CellTypeEntityId;
use App\Component\InstanceEditor\FieldType\FieldTypeEntityId;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Module;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use App\Entity\Site\Cemetery\Cemetery;
use App\Repository\Site\BurialRepository;
use App\Traits\EntityFields\CreatedAtLastModified;
use App\Traits\EntityFields\Site\Burial\Age;
use App\Traits\EntityFields\Site\Burial\AlleyName;
use App\Traits\EntityFields\Site\Burial\BirthDate;
use App\Traits\EntityFields\Site\Burial\BirthYear;
use App\Traits\EntityFields\Site\Burial\BurialTypeName;
use App\Traits\EntityFields\Site\Burial\CemeteryName;
use App\Traits\EntityFields\Site\Burial\DeathDate;
use App\Traits\EntityFields\Site\Burial\DeathYear;
use App\Traits\EntityFields\Site\Burial\FirstName;
use App\Traits\EntityFields\Site\Burial\FullName;
use App\Traits\EntityFields\Site\Burial\Id;
use App\Traits\EntityFields\Site\Burial\LastName;
use App\Traits\EntityFields\Site\Burial\Latitude;
use App\Traits\EntityFields\Site\Burial\Longitude;
use App\Traits\EntityFields\Site\Burial\MiddleName;
use App\Traits\EntityFields\Site\Burial\Obituary;
use App\Traits\EntityFields\Site\Burial\PhotoPath1;
use App\Traits\EntityFields\Site\Burial\PhotoPath2;
use App\Traits\EntityFields\Site\Burial\SectionName;
use DateTime;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Index;

#[Module(title: 'Burial', tab_order: [
    TabDef::GENERAL => 1000,
    TabDef::TEXT => 2000,
    TabDef::SHORT => 2100,
    TabDef::FULL => 2200,
    TabDef::IMAGE => 1000000,
    TabDef::SEO => 10000000,
    TabDef::ADDITIONAL => 1000000000,
    TabDef::SECURITY => 10000518,
    TabDef::MAP => 10000618,
    'Obituary' => 2000,
])]
#[Entity(repositoryClass: BurialRepository::class)]
#[Index(columns: ['last_name'], name: 'last_name', options: ["lengths"=>["40"]])]
#[Index(columns: ['first_name'], name: 'first_name', options: ["lengths"=>["40"]])]
#[Index(columns: ['middle_name'], name: 'middle_name', options: ["lengths"=>["40"]])]
#[Index(columns: ['cemetery_name'], name: 'cemetery_name', options: ["lengths"=>["40"]])]
#[Index(columns: ['city_id'], name: 'city_id')]
#[Index(columns: ['cemetery_id'], name: 'cemetery_id')]
#[Index(columns: ['last_name', 'first_name', 'middle_name'], name: 'names', options: ["lengths"=>["40","40","40"]])]
#[Index(columns: ['last_name', 'first_name', 'middle_name', 'cemetery_name'], name: 'names_cemetery', options: ["lengths"=>["40","40","40","40"]])]
class Burial
{
    use Id,
        FirstName, MiddleName, LastName, FullName, Obituary,
        Birthdate, BirthYear, DeathDate, DeathYear, Age,
        BurialTypeName, SectionName, AlleyName, CemeteryName,
        Latitude, Longitude, PhotoPath1, PhotoPath2, CreatedAtLastModified;

    public function __construct()
    {
        $this->created = new DateTime;
    }

    #[Property(title: 'City')]
    #[Cell(type: CellTypeEntityId::class, order: 1000000, width: 220, options: ['accessor' => 'getName', 'data_class' => City::class])]
    #[Widget(type: FieldTypeEntityId::class, order: 1000000, tab: TabDef::GENERAL, options: ['data_class' => City::class])]
    #[Column(type: 'bigint', nullable: true)]
    private ?int $cityId = null;

    public function getCityId(): ?int
    {
        return $this->cityId;
    }

    public function setCityId(?int $cityId): static
    {
        $this->cityId = $cityId;
        return $this;
    }

    #[Property(title: 'Cemetery')]
    #[Cell(type: CellTypeEntityId::class, order: 2000000, width: 220, options: ['accessor' => 'getName', 'data_class' => Cemetery::class])]
    #[Widget(type: FieldTypeEntityId::class, order: 2000000, tab: TabDef::GENERAL, options: ['data_class' => Cemetery::class])]
    #[Column(type: 'bigint', nullable: true)]
    private ?int $cemeteryId = null;

    public function getCemeteryId(): ?int
    {
        return $this->cemeteryId;
    }

    public function setCemeteryId(?int $cemeteryId): static
    {
        $this->cemeteryId = $cemeteryId;
        return $this;
    }
}
