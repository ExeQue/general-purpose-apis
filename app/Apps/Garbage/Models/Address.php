<?php


namespace App\Apps\Garbage\Models;


use App\Apps\Garbage\Exceptions\AddressNotFoundException;
use App\Traits\HasDataContainer;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Class Address
 *
 * @property-read string $id
 * @property-read string $kvhx
 * @property-read int    $status
 * @property-read int    $darstatus
 * @property-read string $href
 * @property-read array  $historik
 * @property-read string $etage
 * @property-read string $dør
 * @property-read string $adressebetegnelse
 * @property-read array  $adgangsadresse
 *
 * @package App\Apps\Garbage\Models
 * @author Morten Harders <mmh@harders-it.dk>
 */
class Address implements \JsonSerializable, Arrayable
{
    use HasDataContainer;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public static function locate(string $address) : ?static
    {
        return \Cache::remember("address-locate-$address", now()->addDay(), function () use ($address) {
            $response = \Http::get('https://api.dataforsyningen.dk/adresser', [
                'q' => $address,
            ]);

            $data = $response->json('0');

            if (!$data) {
                throw new AddressNotFoundException($address);
            }

            return new static($response->json('0'));
        });
    }

    public function short() : string
    {
        $street = $this->get('adgangsadresse.vejstykke.adresseringsnavn');
        $number = $this->get('adgangsadresse.husnr');

        return "$street $number";
    }

    public function long() : string
    {
        return $this->adressebetegnelse;
    }

    public function accessAddress() : AccessAddress
    {
        return new AccessAddress($this->adgangsadresse);
    }

    public function jsonSerialize() : array
    {
        return $this->toArray();
    }

    public function toArray()
    {
        return [
            'long'  => $this->long(),
            'short' => $this->short(),
        ];
    }
}
