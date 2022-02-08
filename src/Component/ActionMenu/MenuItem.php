<?php namespace App\Component\ActionMenu;

use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

class MenuItem implements JsonSerializable
{
    /** @var static[] */
    protected static array $instances = [];

    protected string $id;

    public function getId(): string
    {
        return $this->id;
    }

    /** @throws Exception */
    public function setId(string $id)
    {
        $this->id = $id;
        static::registerInstance($this);
    }

    protected string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): MenuItem
    {
        $this->name = $name;
        return $this;
    }

    protected bool $disabled = false;

    protected ?string $class = null;

    /**
     * The target attribute specifies where to open the linked document.
     * Variants: _blank|_self|_parent|_top|framename
     * @noinspection SpellCheckingInspection
     */
    protected ?string $target = null;

    protected Action $action;

    /** @var Icon[] */
    protected array $icon = [];

    /** @throws Exception */
    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
        static::registerInstance($this);
    }

    /** @throws Exception */
    public function __wakeup()
    {
        static::registerInstance($this);
    }

    public static function getInstance(string $id): ?static
    {
        return static::$instances[$id] ?? null;
    }

    /** @throws Exception */
    private static function registerInstance(MenuItem $instance)
    {
        $id = $instance->getId();
        if (array_key_exists($id, static::$instances)) {
            throw new Exception('duplicate id: ' . $id);
        }
        static::$instances[$id] = $instance;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    public function setDisabled(bool $disabled): MenuItem
    {
        $this->disabled = $disabled;
        return $this;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(?string $class): MenuItem
    {
        $this->class = $class;
        return $this;
    }

    public function getTarget(): ?string
    {
        return $this->target;
    }

    public function setTarget(?string $target): MenuItem
    {
        $this->target = $target;
        return $this;
    }

    public function getAction(): ?Action
    {
        return $this->action;
    }

    public function setAction(Action $action): MenuItem
    {
        $this->action = $action;
        return $this;
    }

    /** @return Icon[] */
    public function getIcon(): array
    {
        return $this->icon;
    }

    public function addIcon(Icon $icon): MenuItem
    {
        $this->icon[] = $icon;
        return $this;
    }

    public function clearIcon(): static
    {
        $this->icon = [];
        return $this;
    }

    #[ArrayShape(['id' => "string", 'name' => "string", 'disabled' => "bool", 'target' => "null|string", 'class' => "null|string", 'icon' => "string[]", 'handler' => "mixed", 'url' => "mixed"])]
    public function jsonSerialize(): array
    {
        /** @noinspection DuplicatedCode */
        $data = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'disabled' => $this->isDisabled(),
            'target' => $this->getTarget(),
            'class' => $this->getClass()
        ];
        $action = ($this->getAction());
        if ($action instanceof Url) {
            $data['url'] = $action->getUrl();
        }
        if ($action instanceof Route) {
            $data['url'] = $action->generateUrl();
        }
        if ($action instanceof Handler) {
            $data['handler'] = $action->getHandler();
        }
        $data['icon'] = array_map(function (Icon $i) {
            return $i->getIcon();
        }, $this->getIcon());
        return $data;
    }
}
