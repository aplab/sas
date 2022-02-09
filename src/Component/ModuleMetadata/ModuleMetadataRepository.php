<?php namespace App\Component\ModuleMetadata;

use Psr\Cache\InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use Symfony\Contracts\Cache\CacheInterface;


class ModuleMetadataRepository
{
    const CACHE_KEY_DELIMITER = '.';
    private string $cacheKeyPrefix;
    private CacheInterface $cache;

    public function __construct(CacheInterface $cache)
    {
        $class = get_class($this);
        $this->cacheKeyPrefix = md5($class);
        $this->cache = $cache;
    }

    /**
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public function getMetadata($object): ModuleMetadata
    {
        $reflection_class = new ReflectionClass($object);
        $class_name = $reflection_class->getName();
        $cache_key_suffix = md5($class_name);
        $cache_key = join(static::CACHE_KEY_DELIMITER, [
            $this->cacheKeyPrefix, $cache_key_suffix
        ]);
        return $this->cache->get($cache_key, function () use ($reflection_class) {
            return new ModuleMetadata($reflection_class);
        });
    }

    public function getCacheKeyPrefix(): string
    {
        return $this->cacheKeyPrefix;
    }

    public function getCache(): CacheInterface
    {
        return $this->cache;
    }
}
