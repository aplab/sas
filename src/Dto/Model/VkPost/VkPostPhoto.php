<?php declare(strict_types=1);

namespace App\Dto\Model\VkPost;

class VkPostPhoto
{
    protected int    $id;
    protected int    $albumId;
    protected int    $ownerId;
    protected int    $userId;
    protected string $text;
    protected int    $date;
    protected string $accessKey;
    protected array  $sizes;

    public function __construct(array $data)
    {
        $this->id        = $data['id'];
        $this->albumId   = $data['album_id'] ?? 0;
        $this->ownerId   = $data['owner_id'];
        $this->userId    = $data['user_id'] ?? 0;
        $this->text      = $data['text'] ?? '';
        $this->date      = $data['date'];
        $this->accessKey = $data['access_key'];
        if (isset($data['sizes']) && is_array($data['sizes'])) {
            $this->initSizes($data['sizes']);
        }
        if (isset($data['preview']['photo']['sizes']) && is_array($data['preview']['photo']['sizes'])) {
            $this->initSizes($data['preview']['photo']['sizes']);
        }
    }

    private function initSizes(array $data): void
    {
        $this->sizes = [];
        foreach ($data as $data_item) {
            $this->sizes[] = new VkPostPhotoSize($data_item);
        }
    }

    public function getMaxSize(): ?VkPostPhotoSize
    {
        usort($this->sizes, function (VkPostPhotoSize $a, VkPostPhotoSize $b) {
            return $a->getWidth() <=> $b->getWidth();
        });
        return end($this->sizes) ?: null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAlbumId(): int
    {
        return $this->albumId;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getDate(): int
    {
        return $this->date;
    }

    public function getAccessKey(): string
    {
        return $this->accessKey;
    }

    public function getSizes(): array
    {
        return $this->sizes;
    }
}
