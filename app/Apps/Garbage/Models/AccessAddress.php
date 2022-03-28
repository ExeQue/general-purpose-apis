<?php


namespace App\Apps\Garbage\Models;


use App\Traits\HasDataContainer;

class AccessAddress
{
    use HasDataContainer;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
