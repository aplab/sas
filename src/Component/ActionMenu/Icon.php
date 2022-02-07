<?php namespace App\Component\ActionMenu;

class Icon
{
    // Icon string, e.g. "fas fa-users" (without quotes)
    protected string $icon;

    public function __construct(string $icon)
    {
        $this->icon = $icon;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): Icon
    {
        $this->icon = $icon;
        return $this;
    }
}
