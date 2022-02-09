<?php /** @noinspection PhpMultipleClassDeclarationsInspection */ namespace App\Component\ModuleMetadata;

use Attribute;
use Doctrine\ORM\Mapping\Annotation;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Property implements Annotation
{
    /** @var Widget[] */
    private array $widget = [];

    /** @var Cell[] */
    private array $cell;

    private string $title;
    private string $description;
    private string $help;
    private string $comment;
    private string $label;
    private bool $readonly;

    public function __construct(
        string  $title,
        ?string $description = null,
        ?string $help = null,
        ?string $comment = null,
        ?string $label = null,
        bool    $readonly = false,
    )
    {
        $this->title = $title;
        $this->description = $description ?? $this->title;
        $this->help = $help ?? $this->title;
        $this->comment = $comment ?? $this->title;
        $this->label = $label ?? $this->title;
        $this->readonly = $readonly ?? false;
    }

    /** @return Widget[] */
    public function getWidget(): array
    {
        return $this->widget;
    }

    public function setWidget(Widget ...$widget): static
    {
        $this->widget = $widget;
        return $this;
    }

    public function isReadonly(): bool
    {
        return $this->readonly;
    }

    public function setReadonly(bool $readonly): static
    {
        $this->readonly = $readonly;
        return $this;
    }

    /** @return Cell[] */
    public function getCell(): array
    {
        return $this->cell;
    }

    public function setCell(Cell ...$cell): static
    {
        $this->cell = $cell;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getHelp(): string
    {
        return $this->help;
    }

    public function setHelp(string $help): static
    {
        $this->help = $help;
        return $this;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): static
    {
        $this->comment = $comment;
        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;
        return $this;
    }
}
