<?php


namespace App\Apps\Garbage\Models;


use Illuminate\Support\Collection;
use function collect;

class County implements \JsonSerializable
{
    protected string $key;
    protected string $name;
    protected string $code;

    protected function __construct(string $code, string $key, string $name)
    {
        $this->key  = $key;
        $this->name = $name;
        $this->code = $code;
    }

    public static function available() : Collection
    {
        return collect(config('garbage.counties'))->map(function (array $county) {
            return new static(...$county);
        })->sortBy(fn(County $county) => $county->name())->values();
    }

    public static function locate(string $address) : ?County
    {
        $address = Address::locate($address);

        return static::available()->first(fn(County $county) => $county->code() == $address->get('adgangsadresse.kommune.kode'));
    }

    public function jsonSerialize()
    {
        return [
            'key'  => $this->key,
            'name' => $this->name,
            'code' => $this->code,
        ];
    }

    public function key() : string
    {
        return $this->key;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function code() : string
    {
        return $this->code;
    }
}
