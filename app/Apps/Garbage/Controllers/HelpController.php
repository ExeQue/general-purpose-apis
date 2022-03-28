<?php


namespace App\Apps\Garbage\Controllers;


use App\Apps\Garbage\Downloads\YAML;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function help(Request $request)
    {
        $address = $request->input('address');

        $lookup = null;
        $error  = null;
        if ($address) {
            try {
                $lookup = (new ApiController())->fetchInformation($address);
            } catch (\Exception $exception) {
                $error = $exception;
            }
        }

        return view('garbage.index', [
            'garbage' => $lookup,
            'error'   => $error,
        ]);
    }

    public function download($address, $type, $service = null)
    {
        try {
            $lookup = (new ApiController())->fetchInformation($address);

            $lookup->hasServices();

            $content = match ($type) {
                'yaml' => new YAML($lookup),
            };

            return $content->download();
        } catch (\Exception $exception) {
        }

        return response(status: 400);
    }
}
