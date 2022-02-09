<?php namespace App\Component\Menu;

class Handler extends Action
{
    private string $handler;

    public function __construct(string $handler)
    {
        $this->handler = $handler;
    }

    public function getHandler(): string
    {
        return $this->handler;
    }

    public function setHandler(string $handler): Handler
    {
        $this->handler = $handler;
        return $this;
    }
}
