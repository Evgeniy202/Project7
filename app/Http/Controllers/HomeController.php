<?php

namespace App\Http\Controllers;

use App\Functions\Sessions\GetCategories;
use App\Models\Banner;
use App\Models\ProductImage;
use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = GetCategories::getCategoriesList();
        $products = Products::query()->where('isAvailable', 1)
            ->where('isFavorite', 1)
            ->where('count', '>', 0)
            ->inRandomOrder()
            ->paginate(30);
        $productsImages = ProductImage::getMainImages($products);
        $banners = Banner::getBanners();

        return view('home', [
            'categories' => $categories,
            'products' => $products,
            'productsImages' => $productsImages,
            'banners' => $banners,
        ]);
    }
}
