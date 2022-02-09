<?php namespace App\Component\SystemState;

use App\Util\Path;
use RuntimeException;
use Throwable;

class SystemState
{
    private int $id;

    public function getId(): int
    {
        return $this->id;
    }

    private function __construct(int $id = 0)
    {
        $this->id = $id;
        $this->data = [];
    }

    private array $data;

    public function __get(mixed $name): DataBag
    {
        return $this->get($name);
    }

    public function get(mixed $name): DataBag
    {
        $key = self::k($name);
        if (!array_key_exists($key, $this->data)) {
            $this->data[$key] = new DataBag;
        }
        if (!($this->data[$key] instanceof DataBag)) {
            $this->data[$key] = new DataBag;
        }
        return $this->data[$key];
    }

    public function __set(mixed $name, mixed $value)
    {
        throw new RuntimeException('direct modification not allowed');
    }

    private static function k($name): string
    {
        return md5(serialize($name));
    }

    public function purge(string $name)
    {
        $key = $this->k($name);
        unset($this->data[$key]);
    }

    public static function create(int $id, SystemStateManager $manager): SystemState
    {
        $path = new Path($manager->getDataDir(), $id);
        $fs = $manager->getFilesystem();
        if (!$fs->exists($path)) {
            return new static($id);
        }
        $data = file_get_contents($path);
        try {
            $o = unserialize($data);
            if (!($o instanceof static)) {
                throw new RuntimeException('wrong data');
            }
            if ($o->getId() !== $id) {
                throw new RuntimeException('id mismatch');
            }
            return $o;
        } catch (Throwable $exception) {
            $fs->remove($path);
            return new static($id);
        }
    }
}
