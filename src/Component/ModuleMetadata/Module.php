<?php /** @noinspection PhpMultipleClassDeclarationsInspection */


namespace App\Component\ModuleMetadata;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Module
{
    const TAB_ORDER_EXAMPLE = [
        TabDef::GENERAL => 1000,
        TabDef::TEXT => 2000,
        TabDef::SHORT => 2100,
        TabDef::FULL => 2200,
        TabDef::IMAGE => 1000000,
        TabDef::SEO => 10000000,
        TabDef::ADDITIONAL => 10000418,
        TabDef::SECURITY => 10000518,
        TabDef::MAP => 10000618,
    ];

    public function __construct(
        string  $title,
        ?string $description = null,
        ?string $help = null,
        ?string $comment = null,
        ?string $name = null,
        ?string $label = null,
        array   $tab_order = self::TAB_ORDER_EXAMPLE,
    )
    {
        $this->title = $title;
        $this->description = $description ?? $this->title;
        $this->help = $help ?? $this->title;
        $this->comment = $comment ?? $this->title;
        $this->name = $name ?? $this->title;
        $this->label = $label ?? $this->title;
        $this->tabOrder = $tab_order ?? [];
    }

    private array $tabOrder;
    private string $title;
    private string $description;
    private string $help;
    private string $comment;
    private string $name;
    private string $label;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Module
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Module
    {
        $this->description = $description;
        return $this;
    }

    public function getHelp(): string
    {
        return $this->help;
    }

    public function setHelp(string $help): Module
    {
        $this->help = $help;
        return $this;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): Module
    {
        $this->comment = $comment;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Module
    {
        $this->name = $name;
        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): Module
    {
        $this->label = $label;
        return $this;
    }

    public function getTabOrder(): array
    {
        return $this->tabOrder;
    }

    public function setTabOrder(array $tabOrder): Module
    {
        $this->tabOrder = $tabOrder;
        return $this;
    }
}
