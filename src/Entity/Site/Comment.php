<?php

namespace App\Entity\Site;

use App\Component\ModuleMetadata;
use App\Traits\EntityFields\Active;
use App\Traits\EntityFields\CreatedAtLastModified;
use App\Traits\EntityFields\Email;
use App\Traits\EntityFields\Id;
use App\Traits\EntityFields\IpAddress;
use App\Traits\EntityFields\Name;
use App\Traits\EntityFields\ObjectId;
use App\Traits\EntityFields\ObjectType;
use App\Traits\EntityFields\ParentId;
use App\Traits\EntityFields\PublicationDatetime;
use App\Traits\EntityFields\UserAgent;
use App\Traits\EntityFields\UserId;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Index;

#[ModuleMetadata\Module(title: 'Comment', tab_order: [
    'General' => 1000,
    'Text' => 2000,
    'Short' => 2100,
    'Full' => 2200,
    'Image' => 1000000,
    'SEO' => 10000000,
    'Additional' => 10000418
])]
#[Entity(repositoryClass: 'App\Repository\Site\CommentRepository')]
#[Index(columns: ['parent_id'], name: 'parent_id')]
#[Index(columns: ['object_type', 'object_id'], name: 'object_typeid')]
#[Index(columns: ['object_type', 'object_id', 'created_at'], name: 'object_typeid_crtd')]
#[Index(columns: ['object_id', 'object_type'], name: 'object_idtype')]
#[Index(columns: ['active'], name: 'active')]
class Comment
{
    use Id;
    use Name;
    use PublicationDatetime;
    use \App\Traits\EntityFields\Comment;
    use Active;
    use CreatedAtLastModified;
    use UserAgent;
    use IpAddress;
    use Email;
    use ObjectType;
    use ObjectId;
    use UserId;
    use ParentId;
}
