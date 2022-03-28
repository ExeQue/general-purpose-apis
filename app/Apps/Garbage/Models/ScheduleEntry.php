<?php


namespace App\Apps\Garbage\Models;


use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;

class ScheduleEntry implements \JsonSerializable, Arrayable
{
    protected string $when;
    protected Carbon $ref_date;

    public function __construct(string $when, Carbon $ref_date)
    {
        $this->when     = (string) \Str::of($when)->match('/\d{2}-\d{2}-\d{4}/');
        $this->ref_date = $ref_date;
    }

    public function date() : Carbon
    {
        return Carbon::parse($this->when, 'Europe/Copenhagen')->locale(\App::getLocale());
    }

    public function valid() : bool
    {
        return !!$this->when;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray()
    {
        return [
            'date'  => $this->date()?->format('Y-m-d'),
            'local' => $this->date() ? value(function () {
                return "{$this->date()->dayName}, {$this->date()->isoFormat('LL')}";
            }) : null,
            'day'   => [
                'long'  => $this->date()?->dayName,
                'short' => $this->date()?->shortDayName,
                'min'   => $this->date()?->minDayName,
            ],
            'in'    => [
                'days'   => $this->daysUntil(),
                'weeks'  => $this->weeksUntil(),
                'months' => $this->monthsUntil(),
                'human'  => $this->inHuman(),
            ],
        ];
    }

    public function refDate() : Carbon
    {
        return $this->ref_date;
    }

    public function inHuman() : ?string
    {
        return $this->date()?->longAbsoluteDiffForHumans($this->refDate());
    }

    public function daysUntil() : ?int
    {
        return $this->date()?->diffInDays($this->refDate());
    }

    public function weeksUntil() : ?int
    {
        return $this->date()?->diffInWeeks($this->refDate());
    }

    public function monthsUntil() : ?int
    {
        return $this->date()?->diffInMonths($this->refDate());
    }
}
