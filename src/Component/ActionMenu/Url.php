<?php namespace App\Component\ActionMenu;


class Url extends Action
{
    private string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): Url
    {
        $this->url = $url;
        return $this;
    }
}
