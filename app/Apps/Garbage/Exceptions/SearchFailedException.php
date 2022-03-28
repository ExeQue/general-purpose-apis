<?php


namespace App\Apps\Garbage\Exceptions;


use Illuminate\Contracts\Support\Responsable;

class SearchFailedException extends \Exception implements Responsable
{

    public function toResponse($request)
    {
        return response([
            'message' => $this->getMessage(),
        ], 400);
    }
}
