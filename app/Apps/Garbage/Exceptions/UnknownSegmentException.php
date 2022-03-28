<?php


namespace App\Apps\Garbage\Exceptions;


use Illuminate\Contracts\Support\Responsable;

class UnknownSegmentException extends \Exception implements Responsable
{

    public function toResponse($request)
    {
        return response([
            'message' => $this->getMessage(),
        ], 404);
    }
}
