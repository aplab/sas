<?php declare(strict_types=1);

namespace App\Tools;

class UrlToLink
{
    const DEFAULT_EXISTING_LINK_PLACEHOLDER = '####DEFAULT_EXISTING_LINK_PLACEHOLDER####';

    protected string $existsLinkPlaceholder = self::DEFAULT_EXISTING_LINK_PLACEHOLDER;

    protected string $text;

    private array $existingLinkFragments = [];

    public function __invoke(string $text): string
    {
        $this->text = $text;
        $this->replaceExistingLinks();
        $this->convertUrlToLink();
        $this->repairExistingLinks();
        return $this->text;
    }

    private function replaceExistingLinks()
    {
        if (preg_match_all('/<a[^>]+>.*?<\/a>/isu', $this->text, $matches)) {
            $this->existingLinkFragments = $matches;
        } else {
            $this->existingLinkFragments = [];
        }
    }

    private function repairExistingLinks()
    {
        if (empty($this->existingLinkFragments)) {
            return;
        }
        $this->text = str_replace(
            array_fill(
                0,
                sizeof($this->existingLinkFragments),
                static::DEFAULT_EXISTING_LINK_PLACEHOLDER),
            $this->existingLinkFragments,
            $this->text
        );
    }

    function convertUrlToLink()
    {
        $text = $this->text;
        $text= preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\" >$3</a>", $text);
        $text= preg_replace("/(^|[\n ])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"http://$3\" >$3</a>", $text);
        $text= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href=\"mailto:$2@$3\">$2@$3</a>", $text);
        $this->text = $text;
    }
}
