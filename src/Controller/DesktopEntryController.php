<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.08.2018
 * Time: 17:56
 */

namespace App\Controller;


use App\Entity\DesktopEntry;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/desktop-entry', name: 'desktop_entry_')]
class DesktopEntryController extends ReferenceController
{
    protected string $entityClassName = DesktopEntry::class;
}
