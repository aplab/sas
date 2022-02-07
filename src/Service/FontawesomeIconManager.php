<?php


namespace App\Service;


use BCA\FontAwesomeIterator\Iterator;

class FontawesomeIconManager
{
    const PATH_CSS = '/css/fontawesome.css';
    const PATH_SVGS = [
        'fas' => '/svgs/solid',
        'fab' => '/svgs/brands',
        'far' => '/svgs/regular',
    ];

    private string $path;
    private ?Iterator $iterator = null;

    public function __construct(string $path_to_fontawesome_css)
    {
        $this->path = $path_to_fontawesome_css;
    }

    public function getIterator(): Iterator
    {
        if (is_null($this->iterator)) {
            $this->iterator = new Iterator($this->path . self::PATH_CSS);
        }
        $this->iterator->rewind();
        return $this->iterator;
    }

    public function buildData()
    {
        $data = [];
        $iter = $this->getIterator();
        $iter_prefix = $iter->getPrefix();
        foreach ($iter as $item) {
            $class = $item->class;
            $name = substr($class, strlen($iter_prefix) + 1);
            // workaround skip too long icon
            if (false !== strpos($name, 'font-awesome-logo-full')) {
                continue;
            }
            foreach (self::PATH_SVGS as $prefix => $path) {
                if (file_exists($this->path . $path . '/' . $name . '.svg')) {
                    $data[] = [
                        'name' => $item->name,
                        'code' => $item->unicode,
                        'class' => $prefix . ' ' . $item->class,
                    ];
                }
            }
        }
        usort($data, function ($a, $b) {
            return $b['name'] <=> $a['name'];
        });
        return $data;
    }
}