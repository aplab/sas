<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'site:import-data-ekb-archive',
    description: 'Add a short description for your command',
)]
class SiteImportDataEkbArchiveCommand extends SiteImportDataAbstractCommand
{
    const CONNECTION_NAME = 'ekbarchive';
    const CITY_NAME = 'Екатеринбург';
}
