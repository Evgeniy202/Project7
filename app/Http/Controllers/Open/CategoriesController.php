<?php

namespace App\Http\Controllers\Open;

use App\Functions\Features\ValuesOfFeatures;
use App\Functions\Sessions\GetCategories;
use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\CharOfCategory;
use App\Models\ProductDiscount;
use App\Models\ProductImage;
use App\Models\Products;
use App\Models\ValueOfChar;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Categories $category)
    {
        $categories = GetCategories::getCategoriesList();
        $products = Products::query()
            ->where('category', $category->id)
            ->where('isAvailable', 1)
            ->where('count', '>', 0)
            ->inRandomOrder()->paginate(20);
        $images = ProductImage::getMainImages($products);
        $features = CharOfCategory::query()
            ->where('category', $category->id)
            ->orderBy('numberInFilter')->get();
        $values = ValuesOfFeatures::getValues($features);
        $productsDiscount = ProductDiscount::getDiscountsToProducts($category->id);

        return view('public.products.category', [
            'currentCategory' => $category,
            'categories' => $categories,
            'products' => $products,
            'images' => $images,
            'features' => $features,
            'values' => $values,
            'discounts' => $productsDiscount,
        ]);
    }
}
