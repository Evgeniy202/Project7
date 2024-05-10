<?php

namespace App\Http\Controllers;

use App\Functions\Sessions\GetCategories;
use App\Models\Banner;
use App\Models\Categories;
use App\Models\ProductDiscount;
use App\Models\ProductImage;
use App\Models\ProductRating;
use App\Models\Products;
use App\Models\Selected;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Products::query()->where('isAvailable', 1)
            ->where('isFavorite', 1)
            ->where('count', '>', 0)
            ->paginate(30);
        $productsImages = ProductImage::getMainImages($products);
        $banners = Banner::getBanners();
        $discounts = ProductDiscount::getDiscounts($products);
        $ratings = ProductRating::getForProducts($products);
        $categoriesList = Categories::all()->pluck('title', 'id')->toArray(); // костиль
        // $sectionsList = Section::query()->orderBy('priority')->pluck('title', 'id')->toArray();
        
        // $sections = Section::orderBy('priority')->get();
        // $categories = Categories::orderBy('section')->get();

        if (!empty(Auth::user()->id))
        {
            $selected = Selected::query()->where('user', Auth::user()->id)->pluck('product')->toArray();
        }

        return view('home', [
            'products' => $products,
            'productsImages' => $productsImages,
            'banners' => $banners,
            'discounts' => $discounts,
            'selected' => $selected ?? null,
            'ratings' => $ratings ?? false,
            // 'categories' => $categories,
            // 'sections' => $sections,
            'categoriesList' => $categoriesList, // костиль
        ]);
    }
}
