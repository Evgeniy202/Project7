<?php

namespace App\Http\Controllers\Open;

use App\Functions\Features\FeaturesOfProducts;
use App\Functions\Features\ValuesOfFeatures;
use App\Functions\Sessions\GetCategories;
use App\Http\Controllers\Controller;
use App\Models\CharOfCategory;
use App\Models\CharOfProduct;
use App\Models\Comment;
use App\Models\ProductDiscount;
use App\Models\ProductImage;
use App\Models\ProductRating;
use App\Models\Products;
use App\Models\Selected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
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
        $featuresOfProduct = FeaturesOfProducts::getValue($product->category, $charsOfProd);
        $values = ValuesOfFeatures::getValues($featuresOfProduct);
        $comments = Comment::query()->where('product', $product->id)->orderBy('updated_at')->get();
        $featuresView = FeaturesOfProducts::getFeaturesOfProductView($charsOfProd, $featuresOfProduct, $values);
        $discount = ProductDiscount::getDiscount($product);

        if (!empty(Auth::user()->id))
        {
            if (!empty(Selected::query()
                ->where('product', $product->id)
                ->where('user', Auth::user()->id)
                ->first())
            )
            {
                $selected = true;
            }
        }

        return view('public.products.productDetail', [
            'product' => $product,
            'categories' => $categories,
            'images' => $images,
            'features' => $featuresView,
            'comments' => $comments,
            'discount' => $discount,
            'selected' => $selected ?? false,
        ]);
    }

    public function searchAll(Request $request)
    {
        $query = $request->input('search');
        $products = Products::searchAllPublic($query);
        $productsImages = ProductImage::getMainImages($products);

        if (empty($products[0])) {
            return redirect()->back()->with(["message" => "error", "mes_text" => "Product no found."]);
        }

        return view('public.products.search', [
            'products' => $products,
            'productsImages' => $productsImages,
        ]);
    }

    public function addComment(Request $request, $productId)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'comment' => 'required',
        ]);

        $comment = new Comment();
        $comment->product = $productId;
        $comment->name = $validatedData['name'];
        $comment->comment = $validatedData['comment'];
        $comment->save();

        return redirect()->back()->with(['message' => 'success', 'mes_text' => 'Your comment added.']);
    }

    public function addRating(Request $request, $productId)
    {
        $rating = ProductRating::query()
            ->where('product_id', $productId)
            ->where('user_id', Auth::user()->id)
            ->first();

        if (empty($rating))
        {
            $rating = new ProductRating();
            $rating->product_id = $productId;
            $rating->user_id = Auth::user()->id;
            $rating->rating = $request->input('rating');
            $rating->save();

            return redirect()->back()->with(['message' => 'success', 'mes_text' => 'Your rating added.']);
        }
        else
        {
            $rating->rating = $request->input('rating');
            $rating->save();

            return redirect()->back()->with(['message' => 'success', 'mes_text' => 'Your rating added.']);
        }
    }
}
