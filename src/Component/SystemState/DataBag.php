<?php namespace App\Component\SystemState;


class DataBag
{
    public function __construct()
    {
    }

    protected array $data = [];

    public function __get(string $name): mixed
    {
        return $this->get($name);
    }

    public function get(string $name, $default = null): mixed
    {
        return array_key_exists($name, $this->data) ? $this->data[$name] : $default;
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __isset($name)
    {
        return array_key_exists($name, $this->data);
    }

    public function __unset($name)
    {
        unset($this->data[$name]);
    }
}
