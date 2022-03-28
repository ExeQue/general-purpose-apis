<?php


namespace App\Apps\Garbage;


use App\Apps\Garbage\Exceptions\CountyNotLocatedException;
use App\Apps\Garbage\Models\Address;
use App\Apps\Garbage\Models\County;
use App\Apps\Garbage\Models\Garbage;
use App\Apps\Garbage\Models\ScheduleEntry;
use App\Apps\Garbage\Models\Search;
use App\Apps\Garbage\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class Handler
{
    protected ?County $county;
    protected Address $address;

    public function __construct(string $address)
    {
        $this->county  = County::locate($address);
        $this->address = Address::locate($address);

        if (!$this->county) {
            throw new CountyNotLocatedException($address);
        }
    }

    public function lookup() : Garbage
    {
        return new Garbage($this);
    }

    public function search() : Search
    {
        return new Search($this->post('Adresse_SearchByString', [
            'searchterm'          => $this->address->short(),
            'addresswithmateriel' => 0,
        ]));
    }

    public function services(string $address_id) : Collection
    {
        $response = $this->post('GetAffaldsplanMateriel_mitAffald', [
            'adrid'  => $address_id,
            'common' => false,
        ]);

        return collect($response['list'] ?? [])->map(function (array $service) {
            return new Service($this, $service);
        })->groupBy(fn(Service $service) => $service->slug());
    }

    public function schedule(string $service_id, Carbon $ref_date)
    {
        $response = $this->post('GetCalender_mitAffald', [
            'materialid' => $service_id,
        ]);

        return collect($response['list'] ?? [])->map(function (string $when) use ($ref_date) {
            $entry = new ScheduleEntry($when, $ref_date);

            if ($entry->valid()) {
                return $entry;
            }

            return null;
        })->filter()->values();
    }

    protected function post(string $endpoint, array $payload)
    {
        $key = $this->county->key();

        $response = \Http::post("https://$key.renoweb.dk/Legacy/JService.asmx/$endpoint", $payload);

        return json_decode($response->json('d'), true);
    }

    public function county() : ?County
    {
        return $this->county;
    }

    public function address() : ?Address
    {
        return $this->address;
    }
}
