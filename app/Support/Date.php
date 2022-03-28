<?php


namespace App\Support;


use Carbon\CarbonInterface;

class Date
{
    public static function short(CarbonInterface $date, bool $with_year = false, string $locale = null) : string
    {
        $date = (clone $date)->locale($locale = $locale ?: \App::getLocale());

        if ($with_year) {
            return match ($locale) {
                'da' => $date->isoFormat('\d. D. MMMM YYYY'),
                default => $date->format('F jS Y')
            };
        }

        return match ($locale) {
            'da' => $date->isoFormat('\d. D. MMMM'),
            default => $date->format('F jS')
        };
    }

    public static function shortWithDay(CarbonInterface $date, bool $with_year = false, string $locale = null) : string
    {
        $date = (clone $date)->locale($locale = $locale ?: \App::getLocale());

        $date = (clone $date)->locale($locale);

        $short = static::short($date, $with_year, $locale);

        return "$date->dayName $short";
    }
}
