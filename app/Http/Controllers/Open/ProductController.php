<?php

namespace App\Http\Controllers\Open;

use App\Functions\Features\FeaturesOfProducts;
use App\Functions\Features\ValuesOfFeatures;
use App\Functions\Sessions\GetCategories;
use App\Http\Controllers\Controller;
use App\Models\CharOfCategory;
use App\Models\CharOfProduct;
use App\Models\Comment;
use App\Models\ProductImage;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Products $product)
    {
        $categories = GetCategories::getCategoriesList();
        $images = ProductImage::query()
            ->where('product', $product->id)
            ->orderBy('isMain', 'desc')
            ->orderBy('position', 'asc')
            ->get();
        $charsOfProd = CharOfProduct::query()
            ->where('product', $product->id)
            ->orderBy('numberInList', 'asc')
            ->get();
        $featuresOfCategory = CharOfCategory::query()
            ->where('category', $product->category)
            ->orderBy('numberInFilter')
            ->get();
        $featuresOfProduct = FeaturesOfProducts::getValue($product->category, $charsOfProd);
        $values = ValuesOfFeatures::getValues($featuresOfProduct);
        $comments = Comment::query()->where('product', $product->id)->orderBy('updated_at');
        $featuresView = FeaturesOfProducts::getFeaturesOfProductView($charsOfProd, $featuresOfProduct, $values);

        return view('public.products.productDetail', [
           'product' => $product,
           'categories' => $categories,
           'images' => $images,
           'features' => $featuresView,
           'comments' => $comments,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products $products)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $products)
    {
        //
    }

    public function searchAll(Request $request)
    {
        $url = explode('/', $request->url());
        $categories = GetCategories::getCategoriesList();

        if (!empty($url[1]))
        {
            if ($url[1] == "Category")
            {
                $currentCategory = explode('?', $url[2])[0];

                $query = $request->input('search');
                $products = Products::searchInCategoryPublic($query, $currentCategory);

                if (empty($products[0]))
                {
                    return redirect()->back()->with(["message" => "error", "mes_text" => "Product no found."]);
                }

                return view('public.products.searchInCategory', [
                    'currentCategory' => $currentCategory,
                    'categories' => $categories,
                    'products' => $products,
                ]);
            }
        }
        else
        {
            $query = $request->input('search');
            $products = Products::searchAllPublic($query);
            $productsImages = ProductImage::getMainImages($products);

            if (empty($products[0]))
            {
                return redirect()->back()->with(["message" => "error", "mes_text" => "Product no found."]);
            }

            return view('public.products.search', [
                'categories' => $categories,
                'products' => $products,
                'productsImages' => $productsImages,
            ]);
        }
    }
}
