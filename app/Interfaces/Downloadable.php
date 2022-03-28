<?php


namespace App\Interfaces;


use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface Downloadable
{
    public function download() : BinaryFileResponse|StreamedResponse;
}
