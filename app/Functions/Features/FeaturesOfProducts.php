<?php


namespace App\Functions\Features;


use App\Models\CharOfCategory;

class FeaturesOfProducts
{
    public static function getValue($categoryId, $features)
    {
        $featuresOfProduct = [];
        $features_get = [];
        $all_features = CharOfCategory::query()->where('category', $categoryId)->get();
        $all_values = new ValuesOfFeatures();
        $all_values = $all_values->getValues($all_features);

        foreach ($features as $item)
        {
            foreach ($all_features as $item_2)
            {
                if ($item_2->id == $item->char)
                {
                    array_push($features_get, $item_2);
                }
            }
        }

        $i = 0;
        foreach ($features as $item)
        {
            $feature = '';
            $feature_id = '';
            $value = '';
            $value_id = '';

            foreach ($all_features as $item_2)
            {
                if ($item_2->id == $item->char)
                {
                    $feature = $item_2->title;
                    $feature_id = $item_2->id;

                    foreach ($all_values as $val)
                    {
                        if ($val->id == $item->value)
                        {
                            $value = $val->value;
                            $value_id = $val->id;
                        }
                    }
                }
            }

            if (!empty($feature) && !empty($value != ''))
            {
                $featuresOfProduct[$i] = [
                    'charsOfProd' => $item->id,
                    'feature' => $feature,
                    'value' => $value,
                    'feature_id' => $feature_id,
                    'value_id' => $value_id,
                    'numberInList' => $item->numberInList,
                ];
            }
            $i++;
        }

        return $featuresOfProduct;
    }

    public static function getFeaturesOfProductView($charOfProd, $features, $values)
    {
        $featuresView = [];
        $i = 0;

        foreach ($charOfProd as $item)
        {
            foreach ($features as $feature)
            {
                if (empty($feature->id))
                {
                    if ($feature['feature_id'] == $item->char)
                    {
                        $featuresView[$i] = ['feature' => $feature['feature']];

                        foreach ($values as $value)
                        {
                            if ($value->id == $item->value)
                            {
                                $featuresView[$i]['id'] = $feature['charsOfProd'];
                                $featuresView[$i]['value'] = $value->value;
                                $featuresView[$i]['charOfProd'] = $item->id;
                                $featuresView[$i]['numberInList'] = $feature['numberInList'];
                                break;
                            }
                        }
                        break;
                    }
                }
                else if ($feature->id == $item->char)
                {
                    $featuresView[$i] = ['feature' => $feature->title];

                    foreach ($values as $value)
                    {
                        if ($value->id == $item->value)
                        {
                            $featuresView[$i]['id'] = $feature->charsOfProd;
                            $featuresView[$i]['value'] = $value->value;
                            $featuresView[$i]['charOfProd'] = $item->id;
                            $featuresView[$i]['numberInList'] = $feature->numberInList;
                            break;
                        }
                    }
                    break;
                }
            }
            $i++;
        }

        return $featuresView;
    }
}
