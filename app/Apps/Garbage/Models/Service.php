<?php


namespace App\Apps\Garbage\Models;


use App\Apps\Garbage\Handler;
use App\Support\Date;
use App\Support\Flatten;
use App\Traits\HasDataContainer;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Class Service
 *
 * @property-read int    $id
 * @property-read string $materielnavn
 * @property-read string $ordningnavn
 * @property-read string $toemningsdage
 * @property-read string $toemningsdato
 * @property-read string $pris
 * @property-read int    $mattypeid
 * @property-read int    $antal
 * @property-read string $vejnavn
 * @property-read int    $modulsort
 * @property-read int    $adrid
 * @property-read int    $fractionid
 * @property-read bool   $viskalender
 * @property-read bool   $afhentningsbestillingmateriel
 * @property-read int    $modulId
 *
 * @package App\Apps\Garbage\Models
 * @author Morten Harders <mmh@harders-it.dk>
 */
class Service implements \JsonSerializable
{
    use HasDataContainer;

    protected Handler $handler;

    public function __construct(Handler $handler, array $data)
    {
        $this->handler = $handler;
        $this->data    = $data;
    }

    public function slug() : string
    {
        return \Str::of($this->ordningnavn)->lower()->replaceMatches('/[^a-z0-9_]/i', '');
    }

    public function schedule() : Collection
    {
        return $this->handler->schedule($this->id, $this->refDate());
    }

    public function nextService() : ?Carbon
    {
        $date = (string) \Str::of($this->toemningsdato)->match('/\d{2}-\d{2}-\d{4}/');

        if (!$date) {
            return null;
        }

        return Carbon::parse($date, 'Europe/Copenhagen')->setTime(12, 0, 0)->locale(\App::getLocale());
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray()
    {
        $next = $this->nextService();

        return Flatten::flatten([
            'name'     => $this->materielnavn,
            'title'    => $next ? value(function () use ($next) {
                $counter = match (true) {
                    $this->today() => __('common.today'),
                    $this->tomorrow() => __('common.tomorrow'),
                    default => trans_choice('common.in_day', $this->daysUntil(), ['num' => $this->daysUntil()])
                };

                return sprintf("%s (%s)", Date::shortWithDay($next), $counter);
            }) : null,
            'address'  => $this->handler->address()->toArray(),
            'service'  => $this->ordningnavn,
            'state'    => value(function () use ($next) {
                return match (true) {
                    $this->today() => 'today',
                    $this->tomorrow() => 'tomorrow',
                    $this->nextService() == null => 'unknown',
                    default => "in_{$this->daysUntil()}_days"
                };
            }),
            'next'     => [
                'date'        => $next?->format('Y-m-d'),
                'local'       => $next ? Date::shortWithDay($next) : null,
                'local_short' => $next ? Date::short($next) : null,
                'day'         => [
                    'long'  => $next?->dayName,
                    'short' => $next?->shortDayName,
                    'min'   => $next?->minDayName,
                ],
                'in'          => [
                    'days'   => $this->daysUntil(),
                    'weeks'  => $this->weeksUntil(),
                    'months' => $this->monthsUntil(),
                    'human'  => $this->inHuman(),
                ],
                'is'          => [
                    'today'      => $this->today(),
                    'tomorrow'   => $this->tomorrow(),
                    'this_week'  => $next?->isSameWeek($this->refDate()),
                    'this_month' => $next?->isSameMonth($this->refDate()),
                ],
            ],
            'schedule' => $this->schedule(),
        ]);
    }

    protected function refDate() : Carbon
    {
        return now('Europe/Copenhagen')->subDay();
    }

    public function today() : ?bool
    {
        return $this->nextService()?->isToday();
    }

    public function tomorrow() : ?bool
    {
        return $this->nextService()?->isTomorrow();
    }

    public function inHuman() : ?string
    {
        if ($this->today()) {
            return __('common.today');
        } elseif ($this->tomorrow()) {
            return __('common.tomorrow');
        }

        return $this->nextService()?->longAbsoluteDiffForHumans($this->refDate());
    }

    public function daysUntil() : ?int
    {
        return $this->nextService()?->diffInDays($this->refDate());
    }

    public function weeksUntil() : ?int
    {
        return $this->nextService()?->diffInWeeks($this->refDate());
    }

    public function monthsUntil() : ?int
    {
        return $this->nextService()?->diffInMonths($this->refDate());
    }
}
