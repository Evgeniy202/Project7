<?php

namespace App\Http\Controllers\Open;

use App\Functions\Features\ValuesOfFeatures;
use App\Functions\Sessions\GetCategories;
use App\Functions\Sorting\Open\CategoryProducts;
use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\CharOfCategory;
use App\Models\ProductDiscount;
use App\Models\ProductImage;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SortController extends Controller
{
    public function productsOfCategory($categoryId, $sort)
    {
        $category = Categories::query()->find($categoryId);
        $products = Products::query()
            ->where('isAvailable', 1)
            ->where('count', '>', 0)
            ->orderByDesc('isFavorite');
        $products = CategoryProducts::sort($products, $sort, $categoryId);

        if ($products == 'normal')
        {
            return redirect()->route('category.show', $category);
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
            'sort' => $sort,
            'activeFeatures' => $activeFeatures ?? null,
        ]);
    }
}
