<?php


namespace App\Apps\Garbage\Controllers;


use App\Apps\Garbage\Exceptions\UnknownSegmentException;
use App\Apps\Garbage\Handler;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function fetchInformation(string $address, string $segment = null)
    {
        $handler = new Handler($address);

        $garbage = $handler->lookup();

        if ($segment) {
            $services = $garbage->services();

            $segments = $services->keys()->implode(', ');

            return $garbage->services()->get($segment, function () use ($segments, $segment) {
                throw new UnknownSegmentException("Unknown segment: $segment | Segments: $segments");
            });
        }

        return $garbage;
    }
}
