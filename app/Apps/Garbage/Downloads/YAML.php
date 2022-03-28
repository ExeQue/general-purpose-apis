<?php


namespace App\Apps\Garbage\Downloads;


use App\Apps\Garbage\Abstracts\Download;
use Symfony\Component\HttpFoundation\StreamedResponse;

class YAML extends Download
{
    public function download() : StreamedResponse
    {
        return response()->streamDownload(function () {
            echo view('garbage.download.yaml', ['garbage' => $this->garbage])->render();
        }, 'garbage.yaml');
    }
}
