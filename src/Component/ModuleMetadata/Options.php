<?php namespace App\Component\ModuleMetadata;

class Options
{
    public function __construct(array $values = [])
    {
        foreach ($values as $name => $value) {
            $this->$name = $value;
        }
    }
}
