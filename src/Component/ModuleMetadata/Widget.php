<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 30.07.2018
 * Time: 20:39
 */

namespace App\Component\ModuleMetadata;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class Widget
{
    public function __construct(
        string  $type,
        int     $order,
        string  $tab,
        ?string $label = null,
        ?string $title = null,
        ?string $help = null,
        ?string $comment = null,
        array   $options = [],
    )
    {
        $this->tab = $tab;
        $this->order = $order;
        $this->type = $type;
        $this->label = $label ?? '';
        $this->title = $title ?? '';
        $this->help = $help ?? '';
        $this->comment = $comment ?? '';
        $this->options = new Options($options);
    }

    private Options $options;

    public function getOptions(): Options
    {
        return $this->options;
    }

    public function setOptions(Options $options): static
    {
        $this->options = $options;
        return $this;
    }

    private string $tab;
    private int $order;
    private string $type;
    private string $label;
    private string $title;
    private string $help;
    private string $comment;

    public function getTab(): string
    {
        return $this->tab;
    }

    public function setTab(string $tab): static
    {
        $this->tab = $tab;
        return $this;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function setOrder(int $order): static
    {
        $this->order = $order;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
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
}
