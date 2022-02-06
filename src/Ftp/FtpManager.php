<?php

namespace App\Ftp;

use Aplab\Pst\Lib\Path;
use RuntimeException;
use SplFileInfo;
use Symfony\Component\HttpKernel\KernelInterface;

class FtpManager
{
    const DEFAULT_CONFIG_FILENAME = '.site_import_data.ini';
    const DEFAULT_CONNECTION_NAME = 'ekb';

    protected SplFileInfo $configLocation;
    protected ?array $configuration = null;

    public function __construct(KernelInterface $kernel)
    {
        $this->configLocation = new SplFileInfo(
            new Path(
                $kernel->getProjectDir(),
                static::DEFAULT_CONFIG_FILENAME
            )
        );
    }

    public function getConfiguration(): array
    {
        if (is_null($this->configuration)) {
            $c = parse_ini_file($this->configLocation->getRealPath(), true, INI_SCANNER_RAW);
            if (false === $c) {
                throw new RuntimeException('unable to load configuration from ini file');
            }
            $this->configuration = $c;
        }
        return $this->configuration;
    }

    public function getConnection($name = self::DEFAULT_CONNECTION_NAME)
    {
        return $this->connections[$name] ?? new Connection($this, new Config($this, $name));
    }
}
