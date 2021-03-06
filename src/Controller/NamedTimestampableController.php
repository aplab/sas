<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.08.2018
 * Time: 17:56
 */

namespace App\Controller;


use App\Entity\NamedTimestampable;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NamedTimestampableController
 * @package App\Controller
 */
#[Route(path: '/named-timestampable', name: 'named_timestampable_')]
class NamedTimestampableController extends ReferenceController
{
    /**
     * @var string
     */
    protected $entityClassName = NamedTimestampable::class;
}
