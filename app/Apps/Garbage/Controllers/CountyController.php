<?php


namespace App\Apps\Garbage\Controllers;


use App\Apps\Garbage\Models\County;
use App\Http\Controllers\Controller;

class CountyController extends Controller
{
    public function list()
    {
        return County::available();
    }

    public function locate(string $address)
    {
        $county = County::locate($address);

        if ($county) {
            return $county;
        }

        $response = \Http::get('https://api.dataforsyningen.dk/datavask/adresser', [
            'betegnelse' => $address,
        ]);

        $suggestions = collect($response->json('resultater'))->map(function (array $result) {
            $address = $result['adresse'];
            $format  = collect([
                sprintf("%s %s", $address['adresseringsvejnavn'], $address['husnr']),
                sprintf("%s %s", $address['etage'], $address['dør']),
                sprintf("%s %s", $address['postnr'], $address['postnrnavn']),
            ]);

            return $format->map(fn($str) => trim($str))->filter()->join(', ');
        });

        if ($suggestions->isNotEmpty()) {
            $first = $suggestions->first();

            return response([
                'message'     => "No exact match for '$address' was found. Did you mean: '$first'?",
                'suggestions' => $suggestions,
            ], 400);
        }

        return response([
            'message' => "No exact match for '$address' was found. No suggestions found either",
        ], 400);
    }
}
