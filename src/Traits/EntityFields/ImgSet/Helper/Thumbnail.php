<?php

namespace App\Traits\EntityFields\ImgSet\Helper;

use App\Service\ThumbnailGenerator;
use App\Util\Path;
use Throwable;

trait Thumbnail
{
    protected function thumbnail(string $path):string
    {
        if (!method_exists($this, 'getThumbnailGenerator')) {
            return $path;
        }
        $tg = $this->getThumbnailGenerator();
        if (!($tg instanceof ThumbnailGenerator)) {
            return $path;
        }
        try {
            $data = $tg->getThumbnail(new \SplFileInfo(new Path($tg->getLocalStorage()->getPublicDir(), $path)));
            return $data['url'];
        } catch (Throwable $exception) {
            return $path;
        }
    }
}
