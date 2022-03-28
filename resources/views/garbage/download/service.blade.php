- platform: rest
name: '{{ $service->materielnavn }}'
resource: '{{ route('garbage.info', ['address' => request('address'), 'segment' => $slug]) . '?lang=' . app()->getLocale() }}'
value_template: '@{{ value_json.title }}'
scan_interval: 3600
json_attributes:
- name
- title
- address_long
- address_short
- service
- state
- next_date
- next_local
- next_local_short
- next_day_long
- next_day_short
- next_day_min
- next_in_days
- next_in_weeks
- next_in_months
- next_in_human
- next_is_today
- next_is_tomorrow
- next_is_this_week
- next_is_this_month
