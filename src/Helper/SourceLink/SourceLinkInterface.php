<?php

namespace App\Helper\SourceLink;

interface SourceLinkInterface
{
    public function getLabel(): string;
    public function setLabel(string $label): SourceLinkInterface;
    public function getUrl(): string;
    public function setUrl(string $url): SourceLinkInterface;
    public function toString(): string;
    public function __toString();
}