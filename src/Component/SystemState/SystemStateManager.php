<?php namespace App\Component\SystemState;

use App\Util\Path;
use Psr\Log\LoggerInterface;
use ReflectionClass;
use Symfony\Component\Filesystem\Filesystem;

class SystemStateManager
{
    private ReflectionClass $reflectionClass;

    private Filesystem $filesystem;

    private Path $dataDir;

    /** @var SystemState[] */
    private array $data;

    public function __construct(string $aplab_admin_data_dir)
    {
        $this->reflectionClass = new ReflectionClass($this);
        $this->filesystem = new Filesystem();
        $this->dataDir = new Path($aplab_admin_data_dir, $this->reflectionClass->getName(), 'data');
        $this->data = [];
        $this->filesystem->mkdir($this->dataDir);
    }

    public function getReflectionClass(): ReflectionClass
    {
        return $this->reflectionClass;
    }

    public function getFilesystem(): Filesystem
    {
        return $this->filesystem;
    }

    public function getDataDir(): string
    {
        return $this->dataDir;
    }

    public function get(int $id = 0): SystemState
    {
        if (!isset($this->data[$id])) {
            $this->data[$id] = SystemState::create($id, $this);
        }
        if (!($this->data[$id] instanceof SystemState)) {
            $this->data[$id] = SystemState::create($id, $this);
        }
        return $this->data[$id];
    }

    public function flush(LoggerInterface $logger)
    {
        foreach ($this->data as $item) {
            $path = new Path($this->dataDir, $item->getId());
            $data = serialize($item);
            $this->filesystem->dumpFile($path, $data);
        }
    }
}
