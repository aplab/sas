<?php declare(strict_types=1);


namespace App\Helper\SourceLink;


abstract class SourceLink implements SourceLinkInterface
{
    private string $label, $url;

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): SourceLinkInterface
    {
        $this->label = $label;
        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): SourceLinkInterface
    {
        $this->url = $url;
        return $this;
    }

    abstract public function toString(): string;

    public function __toString()
    {
        return $this->toString();
    }
}