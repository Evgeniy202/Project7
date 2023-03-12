<?php


namespace App\Functions\Filters;


class CheckFilters
{
    public static function checkFilter($query)
    {
        $data = [];
        $active = [];
        $i = 0;

        foreach (array_keys($query) as $key)
        {
            if (preg_match('/\d+/', $key))
            {
                $data[$i]['feature'] = explode('-', $key)[0];
                $data[$i]['value'] = explode('-', $key)[1];
                array_push($active, $key);
                $i++;
            }
        }

        return [$data, $active];
    }
}
