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
use Illuminate\Support\Facades\Session;

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
        if (empty(Session::get('sort')) || Session::get('sort') == "random")
        {
            $products = Products::query()
                ->where('category', $category->id)
                ->where('isAvailable', 1)
                ->where('count', '>', 0)
                ->inRandomOrder()->paginate(20);
        }
        elseif (Session::get('sort') == 'cheap')
        {
            $products = Products::query()
                ->where('category', $category->id)
                ->where('isAvailable', 1)
                ->where('count', '>', 0)
                ->orderBy('price')->paginate(20);
        }
        elseif (Session::get('sort') == 'expensive')
        {
            $products = Products::query()
                ->where('category', $category->id)
                ->where('isAvailable', 1)
                ->where('count', '>', 0)
                ->orderByDesc('price')->paginate(20);
        }

        $categories = GetCategories::getCategoriesList();
        $images = ProductImage::getMainImages($products ?? null);
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
            'sort' => Session::get('sort') ?? null,
        ]);
    }

    public function sortProducts($categoryId, $sort)
    {
        $categories = GetCategories::getCategoriesList();
        $category = $categories->find($categoryId);

        return redirect()->route('category.show', $category)->with('sort', $sort);
    }
}
