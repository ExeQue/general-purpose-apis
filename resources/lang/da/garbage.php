<?php

return [
    'help'         => [
        'title'              => 'Skraldehåndtering',
        'supported-counties' => 'Understøttede kommuner',
    ],
    'exceptions'   => [
        'county-not-located' => 'Ingen kommune fundet for \':address\'. Tjek din adresse og prøv igen',
        'address-not-found'  => 'Adressen \':address\' blev ikke fundet. Tjek din adresse og prøv igen',
    ],
    'descriptions' => [
        'fields' => [
            'name'               => 'Service titel',
            'title'              => 'Formateret dato til visning på frontend (med tæller)',
            'address_short'      => 'Kort adresse',
            'address_long'       => 'Lang adresse',
            'service'            => 'Service navn',
            'state'              => 'Sensorens tilstand (<code>today</code>, <code>tomorrow</code>, <code>in_{n}_days</code>)',
            'next_date'          => 'Dato for næste afhentning (YYYY-MM-DD)',
            'next_local'         => 'Dato for næste afhentning (localized)',
            'next_day_long'      => 'Langt dagsnavn for næste afhentning',
            'next_day_short'     => 'Kort dagsnavn for næste afhentning',
            'next_day_min'       => 'Minimalt dagsnavn for næste afhentning',
            'next_in_days'       => 'Dage indtil næste afhentning (rundet ned)',
            'next_in_weeks'      => 'Uger indtil næste afhentning (rundet ned)',
            'next_in_months'     => 'Måneder indtil næste afhentning (rundet ned)',
            'next_in_human'      => 'Menneskelæselig (f.eks. 3 uger, 4 dage osv.)',
            'next_is_today'      => '<code>true</code> hvis næste afhentning er i dag, ellers <code>false</code>',
            'next_is_tomorrow'   => '<code>true</code> hvis næste afhentning er i morgen, ellers <code>false</code>',
            'next_is_this_week'  => '<code>true</code> hvis næste afhentning er i denne uge, ellers <code>false</code>',
            'next_is_this_month' => '<code>true</code> hvis næste afhentning er i denne måned, ellers <code>false</code>',
        ],
    ],
];
