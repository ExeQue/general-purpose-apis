<?php


namespace App\Apps\Garbage\Exceptions;


use Illuminate\Contracts\Support\Responsable;

class CountyNotLocatedException extends \Exception implements Responsable
{
    public function __construct(string $address, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(__('garbage.exceptions.county-not-located', ['address' => $address]), $code, $previous);
    }

    public function toResponse($request)
    {
        return response([
            'message' => $this->getMessage(),
        ], 400);
    }
}
