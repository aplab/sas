<?php


namespace App\Helper\SourceLink;


class OytoySourceLink extends SourceLink
{

    public function toString(): string
    {
        if ($this->getLabel() && $this->getUrl()) {
            return '<br><small class="text-secondary">Источник: <a href="' . $this->getUrl() . '" target="_blank" rel="nofollow">' . $this->getLabel() . '</a></small><br/>&nbsp;';
        }
        if ($this->getUrl()) {
            return '<br><small class="text-secondary">Источник: <a href="' . $this->getUrl() . '" target="_blank" rel="nofollow">' . $this->getUrl() . '</a></small><br/>&nbsp;';
        }
        if ($this->getLabel()) {
            return '<br><small class="text-secondary">Источник: ' . $this->getLabel() . '</small><br/>&nbsp;';
        }
        return '';
    }
}