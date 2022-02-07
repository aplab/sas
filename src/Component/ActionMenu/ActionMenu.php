<?php namespace App\Component\ActionMenu;

use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

class ActionMenu implements JsonSerializable
{
    /* @var static[] */
    protected static array $instances = [];
    protected string $id;

    public function getId(): string
    {
        return $this->id;
    }

    /* @throws Exception */
    public function setId(string $id): static
    {
        $this->id = $id;
        static::registerInstance($this);
        return $this;
    }

    /* @var MenuItem[] */
    protected array $items = [];

    /* @return MenuItem[] */
    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(MenuItem $item): static
    {
        $this->items[] = $item;
        return $this;
    }

    /* @throws Exception */
    public function __construct(string $id)
    {
        $this->id = $id;
        static::registerInstance($this);
    }

    /* @throws Exception */
    public function __wakeup()
    {
        static::registerInstance($this);
    }

    public static function getInstance(string $id): ?ActionMenu
    {
        return static::$instances[$id] ?? null;
    }

    /* @throws Exception */
    private static function registerInstance(ActionMenu $instance)
    {
        $id = $instance->getId();
        if (array_key_exists($id, static::$instances)) {
            throw new Exception('Duplicate id: ' . $id);
        }
        static::$instances[$id] = $instance;
    }

    #[ArrayShape(['id' => "string", 'items' => "array|array[]"])]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'items' => array_map(function (MenuItem $i) {
                return $i->jsonSerialize();
            }, $this->items)
        ];
    }

    public function __toString(): string
    {
        return json_encode($this);
    }

    public function __toJson(int|string $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE): string
    {
        return json_encode($this, $options);
    }
}
