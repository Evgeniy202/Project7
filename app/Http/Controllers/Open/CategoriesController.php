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
use App\Models\ValueOfChar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
            $answer = CheckFilters::checkFilter($request->query());
            $activeFeatures = $answer[1];
            $data = $answer[0];
        }

        $products = Products::query()
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

        $products = $products->paginate(2);

        $categories = GetCategories::getCategoriesList();
        $images = ProductImage::getMainImages($products ?? null);
        $features = CharOfCategory::query()
            ->where('category', $category->id)
            ->orderBy('numberInFilter')->get();
        $values = ValuesOfFeatures::getValues($features);
        $productsDiscount = ProductDiscount::getDiscountsToProducts($category->id);
        $price = Products::price($category->id);

        return view('public.products.category', [
            'currentCategory' => $category,
            'categories' => $categories,
            'products' => $products,
            'images' => $images,
            'features' => $features,
            'values' => $values,
            'discounts' => $productsDiscount,
            'activeFeatures' => $activeFeatures ?? null,
            'price' => $price,
        ]);
    }
}
