<?php

namespace App\Http\Controllers\Open;

use App\Functions\Features\ValuesOfFeatures;
use App\Functions\Filters\CheckFilters;
use App\Functions\Sessions\GetCategories;
use App\Functions\Sorting\Open\CategoryProducts;
use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\CharOfCategory;
use App\Models\CharOfProduct;
use App\Models\ProductDiscount;
use App\Models\ProductImage;
use App\Models\ProductRating;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SortController extends Controller
{
    public function productsOfCategory($categoryId, $sort, Request $request)
    {
        $category = Categories::query()->find($categoryId);

        if (!empty($request->query()))
        {
            list($data, $activeFeatures) = CheckFilters::checkFilter($request->query());
        }

        $products = Products::query()
            ->where('category', $categoryId)
            ->where('isAvailable', 1)
            ->where('count', '>', 0)
            ->orderByDesc('isFavorite');
        $products = CategoryProducts::sort($products, $sort, $categoryId);

        if ($products == 'normal')
        {
            return redirect()->route('category.show', $category);
        }

        if (!empty($data))
        {
            $productsFeatures = CharOfProduct::query()
                ->join('char_of_categories', 'char_of_products.char', '=', 'char_of_categories.id')
                ->where('char_of_categories.category', $category->id)
                ->select('product', 'char', 'value')
                ->get()->toArray();

            $products = Products::filter($products, $data, $productsFeatures);
        }

        if (isset($request->query()['min_price']))
        {
            $products = Products::priceFilter($products, $request->query()['min_price'], $request->query()['max_price']);

            $activeFeatures['min_price'] = $request->query()['min_price'];
            $activeFeatures['max_price'] = $request->query()['max_price'];
        }

        $products = $products->paginate(20);
        $images = ProductImage::getMainImages($products ?? null);
        $features = CharOfCategory::query()
            ->where('category', $category->id)
            ->orderBy('numberInFilter')->get();
        $values = ValuesOfFeatures::getValues($features);
        $discounts = ProductDiscount::getDiscounts($products);
        $price = Products::price($category->id);
        $ratings = ProductRating::getForProducts($products);

        return view('public.products.category', [
            'currentCategory' => $category,
            'products' => $products,
            'images' => $images,
            'features' => $features,
            'values' => $values,
            'discounts' => $discounts,
            'sort' => $sort,
            'price' => $price,
            'ratings' => $ratings ?? false,
        ])->with('activeFeatures', $activeFeatures ?? null);
    }
}
