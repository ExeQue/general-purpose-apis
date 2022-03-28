<?php


namespace App\Apps\Garbage\Abstracts;


use App\Apps\Garbage\Models\Garbage;
use App\Interfaces\Downloadable;

abstract class Download implements Downloadable
{
    protected Garbage $garbage;

    public function __construct(Garbage $garbage)
    {
        $this->garbage = $garbage;
    }
}
