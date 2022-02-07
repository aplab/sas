<?php


namespace App\Component\SftpStorage;


use InvalidArgumentException;
use RuntimeException;
use SplFileInfo;
use Throwable;

class SftpStorageManager
{
    const DEFAULT_STORAGE_NAME = 'default';

    private SplFileInfo $configFile;

    private array $config;

    /**
     * @var SftpStorage[]
     */
    protected array $instances;

    public function __construct(string $ini_file_path)
    {
        $this->configFile = new SplFileInfo($ini_file_path);
        $this->configure();
    }

    protected function configure()
    {
        $path = $this->configFile->getPathname();
        if (!file_exists($path)) {
            throw new InvalidArgumentException(sprintf('ini file not found: %s', $path));
        }
        $config_data = parse_ini_file($path, true, INI_SCANNER_NORMAL|INI_SCANNER_TYPED);
        if (!is_array($config_data)) {
            throw new RuntimeException('wrong configuration');
        }
        $this->config = Config::init($config_data);
    }

    public function getStorage(string $name = self::DEFAULT_STORAGE_NAME)
    {
        if (isset($this->instances[$name])) {
            return $this->instances[$name];
        }
        if (!isset($this->config[$name])) {
            throw new InvalidArgumentException(sprintf('storage config not found: %s', $name));
        }
        try {
            $this->instances[$name] = new SftpStorage($this->config[$name]);
            return $this->instances[$name];
        } catch (Throwable $exception) {
            throw new InvalidArgumentException(sprintf('unable to get storage: %s; reason: %s', $name, $exception->getMessage()));
        }
    }
}