<?php

namespace App\Service;

use App\Component\FileStorage\Exception;
use App\Component\FileStorage\LocalStorage;
use Imagick;
use ImagickException;
use RuntimeException;
use SplFileInfo;

class ThumbnailGenerator
{
    const EXTENSION = 'jpg';
    const DEFAULT_WIDTH = 384;
    const DEFAULT_HEIGHT = 400;

    protected LocalStorage $localStorage;

    public function __construct(LocalStorage $l)
    {
        $this->localStorage = $l;
    }

    /**
     * @throws ImagickException|Exception
     */
    public function getThumbnail(SplFileInfo $f, int $width = self::DEFAULT_WIDTH, int $height = self::DEFAULT_HEIGHT): array
    {
        $image = new Imagick($f->getRealPath());
        $image->cropThumbnailImage($width, $height);
        $image->setImageFormat(static::EXTENSION);
        $tmp_handle = tmpfile();
        $image->writeImageFile($tmp_handle);
        if (false === $tmp_handle) {
            throw new RuntimeException('unable to create tmp file');
        }
        $meta = stream_get_meta_data($tmp_handle);
        $tmp_path = $meta['uri'];
        return $this->localStorage->addFile($tmp_path, static::EXTENSION);
    }

    public function getLocalStorage(): LocalStorage
    {
        return $this->localStorage;
    }
}
