<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 05.09.2018
 * Time: 16:03
 */

namespace App\Entity\UserFiles;

use App\Component\DataTableRepresentation\CellType\CellTypeEditId;
use App\Component\DataTableRepresentation\CellType\CellTypeLabel;
use App\Component\DataTableRepresentation\CellType\CellTypeUserFileDirectLink;
use App\Component\DataTableRepresentation\CellType\CellTypeUserFileLink;
use App\Component\InstanceEditor\FieldType\FieldTypeLabel;
use App\Component\InstanceEditor\FieldType\FieldTypeText;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Module;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use App\Traits\EntityFields\CreatedAtLastModified;
use DateTime;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class File
 * @package App\Entity\Userfiles
 */
#[Module(title: 'User files', tab_order: [
    'General' => 1000,
    'Additional' => 10000418
])]
#[Entity(repositoryClass: 'App\Repository\UserFilesRepository')]
#[Table(name: 'user_files')]
class File
{
    public function __construct()
    {
        $this->createdAt = new DateTime;
    }

    #[Property(title: 'ID', readonly: true)]
    #[Cell(type: CellTypeEditId::class, order: 1000, width: 80)]
    #[Widget(type: FieldTypeLabel::class, order: 1000, tab: TabDef::ADDITIONAL)]
    #[Id, GeneratedValue, Column(type: 'bigint')]
    private $id;

    #[NotBlank(message: 'Name should be not blank')]
    #[Property(title: 'Name')]
    #[Cell(type: CellTypeLabel::class, order: 2000, width: 200)]
    #[Cell(type: CellTypeUserFileLink::class, order: 2000, width: 200, title: 'Link')]
    #[Widget(type: FieldTypeText::class, order: 2000, tab: TabDef::GENERAL)]
    #[Column(type: 'string')]
    private $name;

    #[Property(title: 'Filename')]
    #[Cell(type: CellTypeUserFileDirectLink::class, order: 4000, width: 560, title: 'Direct link')]
    #[Column(type: 'string')]
    private $filename;

    #[NotBlank(message: 'Content type should be not blank')]
    #[Property(title: 'Content type')]
    #[Cell(type: CellTypeLabel::class, order: 5000, width: 160)]
    #[Column(type: 'string')]
    private $contentType;

    use CreatedAtLastModified;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function setFilename($filename): static
    {
        $this->filename = $filename;
        return $this;
    }

    public function getContentType()
    {
        return $this->contentType;
    }

    public function setContentType($contentType): static
    {
        $this->contentType = $contentType;
        return $this;
    }
}
