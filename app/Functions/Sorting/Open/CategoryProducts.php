<?php


namespace App\Functions\Sorting\Open;


use Illuminate\Support\Facades\Redirect;
use App\Models\Categories;

class CategoryProducts
{
    public static function sort($products, $sort, $categoryId)
    {
        if ($sort == 'cheap')
        {
            return $products->orderBy('price');
        }
        elseif ($sort == 'expensive')
        {
            return $products->orderByDesc('price');
        }

        return 'normal';
    }
}
