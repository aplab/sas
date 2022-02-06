<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'site:import-data-ekb',
    description: 'Add a short description for your command',
)]
class SiteImportDataEkbCommand extends SiteImportDataAbstractCommand
{
    const CONNECTION_NAME = 'ekb';
    const CITY_NAME = 'Екатеринбург';
}
