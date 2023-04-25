<?php

namespace App\Http\Controllers\Open;

use App\Functions\Features\ValuesOfFeatures;
use App\Functions\Filters\CheckFilters;
use App\Functions\Sessions\GetCategories;
use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\CharOfCategory;
use App\Models\CharOfProduct;
use App\Models\ProductDiscount;
use App\Models\ProductImage;
use App\Models\Products;
use App\Models\Selected;
use App\Models\ValueOfChar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use function League\Flysystem\toArray;

class CategoriesController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  Request $request
     * @param  \App\Models\Categories  $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Categories $category, Request $request)
    {
        if (!empty($request->query()))
        {
            list($data, $activeFeatures) = CheckFilters::checkFilter($request->query());
        }

        $products = Products::query()
            ->where('category', $category->id)
            ->where('isAvailable', 1)
            ->where('count', '>', 0)
            ->orderByDesc('isFavorite');

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

        if (!empty(Auth::user()->id))
        {
            $selected = Selected::query()->where('user', Auth::user()->id)->pluck('product')->toArray();
        }

        return view('public.products.category', [
            'currentCategory' => $category,
            'products' => $products,
            'images' => $images,
            'features' => $features,
            'values' => $values,
            'discounts' => $discounts,
            'price' => $price,
            'selected' => $selected ?? null,
        ])->with('activeFeatures', $activeFeatures ?? null);
    }
}
