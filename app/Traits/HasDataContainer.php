<?php


namespace App\Traits;


trait HasDataContainer
{
    protected array $data = [];

    public function get(string $key, $default = null)
    {
        return data_get($this->data, $key, $default);
    }

    public function __get(string $name)
    {
        return $this->get($name);
    }
}
