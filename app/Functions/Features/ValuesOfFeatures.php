<?php


namespace App\Functions\Features;

use App\Models\ValueOfChar;

class ValuesOfFeatures
{
    public static function getValues($features)
    {
        $values_list = [];
        $allValues = ValueOfChar::query()->orderBy('numberInFilter', 'asc')->get();

        foreach ($features as $feature)
        {
            $values = $allValues->where('char', $feature->id);

            foreach ($values as $value)
            {
                array_push($values_list, $value);
            }
        }

        return $values_list;
    }
}
