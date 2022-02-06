<?php declare(strict_types=1);

namespace App\Dto\Model\VkPost;

class VkPost
{
    const ATTACHMENT_TYPE_PHOTO = 'photo';
    const ATTACHMENT_TYPE_DOC = 'doc';

    protected int    $id;
    protected int    $fromId;
    protected int    $ownerId;
    protected int    $date;
    protected int    $markedAsAds;
    protected string $postType;
    protected string $text;
    protected int    $canDelete;
    protected int    $canPin;
    protected array  $photos;

    public function __construct(array $data)
    {
        $this->id          = $data['id'];
        $this->fromId      = $data['from_id'];
        $this->ownerId     = $data['owner_id'];
        $this->date        = $data['date'];
        $this->markedAsAds = $data['marked_as_ads'];
        $this->postType    = $data['post_type'];
        $this->text        = $data['text'];
        $this->canDelete   = $data['can_delete'] ?? 0;
        $this->canPin      = $data['can_pin'] ?? 0;
        $this->initAttachments($data['attachments'] ?? []);
    }

    protected function initAttachments(array $data)
    {
        foreach ($data as $data_item) {
            dump($data_item);
            if ($data_item['type'] === self::ATTACHMENT_TYPE_PHOTO) {
                $this->initPhoto($data_item[self::ATTACHMENT_TYPE_PHOTO]);
            }
            if ($data_item['type'] === self::ATTACHMENT_TYPE_DOC) {
                $this->initPhoto($data_item[self::ATTACHMENT_TYPE_DOC]);
            }
        }
    }

    protected function initPhoto(array $data): void
    {
        $this->photos[] = new VkPostPhoto($data);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFromId(): int
    {
        return $this->fromId;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    public function getDate(): int
    {
        return $this->date;
    }

    public function getMarkedAsAds(): int
    {
        return $this->markedAsAds;
    }

    public function getPostType(): string
    {
        return $this->postType;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getCanDelete(): int
    {
        return $this->canDelete;
    }

    public function getCanPin(): int
    {
        return $this->canPin;
    }

    public function getPhotos(): array
    {
        return $this->photos ?? [];
    }
}
