<?php


namespace App\Functions\Features;

use App\Models\ValueOfChar;
use Mockery\Exception;

class ValuesOfFeatures
{
    public static function getValues($features)
    {
        $values_list = [];
        $allValues = ValueOfChar::query()->orderBy('numberInFilter', 'asc')->get();

        foreach ($features as $feature)
        {
            $values = [];

            foreach ($allValues as $val)
            {
                if (empty($feature->id))
                {
                    if ($val->char == $feature['feature_id'])
                    {
                        array_push($values, $val);
                    }
                }
                else if ($val->char == $feature->id)
                {
                    array_push($values, $val);
                }
            }

            foreach ($values as $value)
            {
                array_push($values_list, $value);
            }
        }

        return $values_list;
    }
}
