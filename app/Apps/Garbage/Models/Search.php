<?php


namespace App\Apps\Garbage\Models;


use App\Traits\HasDataContainer;

class Search
{
    use HasDataContainer;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function id() : string
    {
        return $this->get('list.0.value');
    }

    public function label() : string
    {
        return $this->get('list.0.label');
    }

    public function wasFound() : bool
    {
        return $this->id() !== '0000';
    }
}
