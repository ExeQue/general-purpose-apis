<?php


namespace App\Apps\Garbage\Models;


use App\Apps\Garbage\Exceptions\SearchFailedException;
use App\Apps\Garbage\Handler;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class Garbage implements \JsonSerializable, Arrayable
{
    protected Handler     $handler;
    protected ?Collection $services = null;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray()
    {
        return [
            'address'  => $this->handler->address(),
            'services' => $this->services(),
        ];
    }

    public function county() : ?County
    {
        return $this->handler->county();
    }

    public function address() : ?Address
    {
        return $this->handler->address();
    }

    public function hasServices() : bool
    {
        return $this->services()->isNotEmpty();
    }

    public function services() : Collection
    {
        if ($this->services) {
            return $this->services;
        }

        $search = $this->handler->search();

        if (!$search->wasFound()) {
            throw new SearchFailedException("Search failed: " . $search->label());
        }

        return $this->services = $this->handler->services($search->id())->flatMap(function (Collection $collection) {
            return $collection->mapWithKeys(function (Service $service, $i) {
                return [
                    $service->slug() . '_' . $i => $service,
                ];
            });
        });
    }
}
