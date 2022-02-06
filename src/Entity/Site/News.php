<?php

namespace App\Entity\Site;

use App\Component\ModuleMetadata;
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

#[ModuleMetadata\Module(title: 'News', tab_order: [
    'General' => 1000,
    'Text' => 2000,
    'Short' => 2100,
    'Full' => 2200,
    'Image' => 1000000,
    'SEO' => 10000000,
    'Additional' => 10000418
])]
#[Entity(repositoryClass: 'App\Repository\Site\NewsRepository')]
#[Index(columns: ["active", "publication_datetime"], name: "actual")]
#[Index(columns: ["publication_datetime"], name: "publication_datetime")]
class News
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

    public function __construct()
    {
        $this->createdAt = new DateTime;
    }
}
