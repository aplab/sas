<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 02.08.2018
 * Time: 17:18
 */

namespace App\Component\ModuleMetadata;


use Doctrine\Common\Annotations\Reader;
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
     * @param $object
     * @return ModuleMetadata
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public function getMetadata($object)
    {
        $reflection_class = new ReflectionClass($object);
        $class_name = $reflection_class->getName();
        $cache_key_suffix = md5($class_name);
        $cache_key = join(static::CACHE_KEY_DELIMITER, [
            $this->cacheKeyPrefix, $cache_key_suffix
        ]);
        return $this->cache->get($cache_key, function () use($reflection_class) {
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

    /**
     * @return Reader
     */
    public function getReader(): Reader
    {
        return $this->reader;
    }
}
