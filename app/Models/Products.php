<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'category',
        'title',
        'slug',
        'description',
        'price',
        'isAvailable',
        'isFavorite',
        'count',
        'created_at',
        'updated_at',
    ];

    public static function searchAdmin($query)
    {
        return Products::query()
            ->where('title', 'LIKE', '%'.$query.'%')
            ->orWhere('slug', 'LIKE', '%'.$query.'%')
            ->paginate(20);
    }

    public static function searchAllPublic($query)
    {
        return Products::query()
            ->where('title', 'LIKE', '%'.$query.'%')
            ->paginate(20);
    }

    public static function searchInCategoryPublic($query, $category)
    {
        return Products::query()
            ->where('category', $category)
            ->where('title', 'LIKE', '%'.$query.'%')
            ->paginate(20);
    }

    public static function filter($products, $data, $productsFeatures)
    {
        $filters = [];
        $features = [];
        $values = [];

        for ($i = 0; $i < count($data); $i++)
        {
            $features[$i] = $data[$i]['feature'];
            $values[$i] = $data[$i]['value'];
        }

        $filters = [];
        $i = 0;

        foreach ($data as $item)
        {
            if ((!empty($filters[0])) && ($filters[$i]['id'] == $item['feature']))
            {
                array_push($filters[$i]['value'], $item['value']);
            }
            elseif ((!empty($filters[0])) && ($filters[$i]['id'] != $item['feature']))
            {
                $i++;
                $filters[$i]['id'] = $item['feature'];
                $filters[$i]['value'] = [$item['value']];
            }
            elseif ($i == 0)
            {
                $filters[$i]['id'] = $item['feature'];
                $filters[$i]['value'] = [$item['value']];
            }
        }

        $items = $products->pluck('id')->toArray();

        foreach ($filters as $filter)
        {
            $current = [];

            foreach ($productsFeatures as $productFeature)
            {
                if ($filter['id'] == $productFeature['char'] && in_array($productFeature['value'], $filter['value']))
                {
                    array_push($current, $productFeature['product']);
                }
            }

            $items = array_intersect($items, $current);
        }

        $products->whereIn('id', $items);

        return $products;
    }
}
