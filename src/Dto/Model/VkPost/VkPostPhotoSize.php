<?php declare(strict_types=1);

namespace App\Dto\Model\VkPost;

use App\Component\Uploader\Exception;
use App\Component\Uploader\ImageUploader;
use App\Tools\SnatchImage;

class VkPostPhotoSize
{
    protected string $type;
    protected string $url;
    protected int $width;
    protected int $height;

    public function __construct(array $data)
    {
        $this->type   = $data['type'];
        $this->url    = $data['url'] ?? $data['src'];
        $this->width  = $data['width'];
        $this->height = $data['height'];
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param ImageUploader $uploader
     * @return string
     * @throws Exception
     * @throws \Exception
     */
    public function download(ImageUploader $uploader)
    {
        $tmp_handle = SnatchImage::snatch($this->getUrl());
        $meta       = stream_get_meta_data($tmp_handle);
        $path       = $meta['uri'];
        $downloadedUrl = $uploader->receive($path);
        $this->isDownloaded = true;
        $this->downloadedUrl = $downloadedUrl;
        return $this->downloadedUrl;
    }

    protected bool $isDownloaded = false;

    protected ?string $downloadedUrl;

    /**
     * @return bool
     */
    public function isDownloaded(): bool
    {
        return $this->isDownloaded;
    }

    /**
     * @return string|null
     */
    public function getDownloadedUrl(): ?string
    {
        return $this->downloadedUrl;
    }
}
