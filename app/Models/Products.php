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

        foreach ($data as $item)
        {
            $filters[$item['feature']][] = $item['value'];
        }

        $items = [];

        foreach ($filters as $id => $values)
        {
            $productIds = [];

            foreach ($productsFeatures as $productFeature)
            {
                if ($productFeature['char'] == $id && in_array($productFeature['value'], $values))
                {
                    $productIds[] = $productFeature['product'];
                }
            }

            if (!empty($productIds))
            {
                $items[] = $productIds;
            }
            else
            {
                $items = [];
            }
        }

        if (!empty($items))
        {
            $items = call_user_func_array('array_intersect', $items);
        }

        return $products->whereIn('id', $items);
    }

    public static function price($categoryId)
    {
        $minPrice = Products::query()
            ->where('category', $categoryId)
            ->min('price');
        $maxPrice = Products::query()
        ->where('category', $categoryId)
        ->max('price');

       return [$minPrice, $maxPrice];
    }
}
