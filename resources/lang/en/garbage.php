<?php

return [
    'help'         => [
        'title'              => 'Garbage Handling',
        'supported-counties' => 'Supported counties',
    ],
    'exceptions'   => [
        'county-not-located' => 'No county located for \':address\'. Please refine your address and try again',
        'address-not-found'  => 'The address \':address\' wasn\'t found. Please refine your address and try again',
    ],
    'descriptions' => [
        'fields' => [
            'name'               => 'Service title',
            'title'              => 'Formatted date for frontend display (with counter)',
            'address_short'      => 'Short address format',
            'address_long'       => 'Long address format',
            'service'            => 'Service name',
            'state'              => 'State of the sensor (<code>today</code>, <code>tomorrow</code>, <code>in_{n}_days</code>)',
            'next_date'          => 'Next service date (YYYY-MM-DD)',
            'next_local'         => 'Next service date (localized)',
            'next_day_long'      => 'Long day name of next service',
            'next_day_short'     => 'Short day name of next service',
            'next_day_min'       => 'Minimal day name of next service',
            'next_in_days'       => 'Days until next service (rounded down)',
            'next_in_weeks'      => 'Weeks until next service (rounded down)',
            'next_in_months'     => 'Months until next service (rounded down)',
            'next_in_human'      => 'Human readable (eg. 3 weeks, 4 days etc.)',
            'next_is_today'      => '<code>true</code> if next service is today, else <code>false</code>',
            'next_is_tomorrow'   => '<code>true</code> if next service is tomorrow, else <code>false</code>',
            'next_is_this_week'  => '<code>true</code> if next service is this week, else <code>false</code>',
            'next_is_this_month' => '<code>true</code> if next service is this month, else <code>false</code>',
        ],
    ],
];
