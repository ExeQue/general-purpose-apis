<?php


namespace App\Support;


use Illuminate\Contracts\Support\Arrayable;

class Flatten
{
    public static function flatten(array|Arrayable $array) : array
    {
        $array = $array instanceof Arrayable ? $array->toArray() : $array;

        $result = [];
        foreach ($array as $key => $value) {
            if (\Arr::accessible($value)) {
                foreach (static::flatten($value) as $sub_key => $sub_value) {
                    $result["{$key}_{$sub_key}"] = $sub_value;

                    if ("{$key}_{$sub_key}" === 'schedule_0') {
                        dd($sub_value);
                    }
                }
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}
