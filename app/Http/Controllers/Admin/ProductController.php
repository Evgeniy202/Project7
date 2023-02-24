<?php

namespace App\Http\Controllers\Admin;

use App\Functions\Features\ValuesOfFeatures;
use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\CharOfCategory;
use App\Models\CharOfProduct;
use App\Models\Comment;
use App\Models\ProductDiscount;
use App\Models\ProductImage;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Functions\Features\FeaturesOfProducts;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $products = Products::query()->orderByDesc('updated_at')->paginate(20);
        $categories = Categories::query()->orderBy('priority')->get();

        return view('admin.products.index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $newProduct = new Products();

        $price = (float)str_replace(',', '.', $request->input('price'));

        $isAvailable = $request->input('isAvailable');
        if ($isAvailable != 1)
        {
            $isAvailable = 0;
        }

        $isFavorite = $request->input('isFavorite');

        if ($isFavorite != 1)
        {
            $isFavorite = 0;
        }

        $newProduct->category = $request->input('category');
        $newProduct->title = $request->input('title');
        $newProduct->slug = $request->input('slug');
        $newProduct->description = $request->input('description');
        $newProduct->count = $request->input('count');
        $newProduct->price = round($price, 2);
        $newProduct->isAvailable = $isAvailable;
        $newProduct->isFavorite = $isFavorite;
        $newProduct->created_at = date("Y-m-d H:i:s");
        $newProduct->updated_at = date("Y-m-d H:i:s");

        if (!empty($request->input('count')))
        {
            $newProduct->count = $request->input('count');
        }

        $newProduct->save();

        $mainImage = new ProductImage();

        $mainImage->product = $newProduct->id;
        $mainImage->isMain = 1;

        $path = $request->file('mainImg')->store('products', 'public');

        $mainImage->image = $path;
        $mainImage->position = 1;

        $mainImage->save();

        return redirect()->route('products.show', $newProduct)
            ->with(["message" => "success", "mes_text" => "Product created!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Products $product)
    {
        $category = Categories::query()->find($product->category);
        $productDiscounts = ProductDiscount::query()
            ->where('product', $product->id)
            ->orderBy('end_date', 'asc')
            ->get();
        $imagesOfProduct = ProductImage::query()
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
        $featuresOfProduct = FeaturesOfProducts::getValue($category->id, $charsOfProd);
        $values = ValuesOfFeatures::getValues($featuresOfProduct);
        $comments = Comment::query()->where('product', $product->id)->orderBy('updated_at');
        $featuresView = FeaturesOfProducts::getFeaturesOfProductView($charsOfProd, $featuresOfProduct, $values);

        return view('admin.products.detail', [
            'product' => $product,
            'category' => $category,
            'productDiscounts' => $productDiscounts,
            'imagesOfProduct' => $imagesOfProduct,
            'charsOfProd' => $charsOfProd,
            'featuresOfProduct' => $featuresOfProduct,
            'values' => $values,
            'featuresView' => $featuresView,
            'comments' => $comments,
            'featuresOfCategory' => $featuresOfCategory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Products $product)
    {
        $price = (float)str_replace(',', '.', $request->input('price'));

        $isAvailable = $request->input('isAvailable');
        if ($isAvailable != 1)
        {
            $isAvailable = 0;
        }

        $isFavorite = $request->input('isFavorite');
        if ($isFavorite != 1)
        {
            $isFavorite = 0;
        }

        $product->isAvailable = $isAvailable;
        $product->isFavorite = $isFavorite;

        if ($product->title != $request->input('title'))
        {
            $product->title = $request->input('title');
        }

        if ($product->slug != $request->input('slug'))
        {
            $product->slug = $request->input('slug');
        }

        if ($product->description != $request->input('description'))
        {
            $product->description = $request->input('description');
        }

        if ($product->price != round($price, 2))
        {
            $product->price = round($price, 2);
        }

        if ($product->count != $request->input('count'))
        {
            $product->count = $request->input('count');
        }

        $product->updated_at = date("Y-m-d H:i:s");

        $product->save();

        return redirect()->back()->with(["message" => "success", "mes_text" => "Product updated!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Products $product)
    {
        $images = ProductImage::query()->where('product', $product->id);
        $discounts = ProductDiscount::query()->where('product', $product->id);

        foreach ($images->get() as $image)
        {
            Storage::disk('public')->delete($image->image);
        }

        $images->delete();
        $discounts->delete();
        $product->delete();

        return redirect()->route('products.index')
            ->with(["message" => "success", "mes_text" => "Product removed!"]);
    }

    public function search(Request $request)
    {
        $query = $request->input('search');
        $products = Products::search($query);
        $categories = Categories::query()->orderBy('priority')->get();

        return view('admin.products.search', ['products' => $products, 'categories' => $categories]);
    }

    public function addImage(Request $request, $productId)
    {
        $newImage = new ProductImage();

        $newImage->product = $productId;
        $newImage->image = $request->file('image')->store('products', 'public');

        if (!empty($request->input('position')))
        {
            $newImage->position = $request->input('position');
        }

        $newImage->isMain = 0;
        $newImage->created_at = date("Y-m-d H:i:s");
        $newImage->updated_at = date("Y-m-d H:i:s");

        $newImage->save();

        return redirect()->back()->with(["message" => "success", "mes_text" => "Product's image added!"]);
    }

    public function changeImage(Request $request, $productId, $imageId)
    {
        $image = ProductImage::query()->find($imageId);
        $product = Products::query()->find($productId);
        $isMain = $request->input('isMain');

        if ($isMain != 1)
        {
            $isMain = 0;
        }

        if ($request->input('position') != $image->position)
        {
            $image->position = $request->input('position');
            $image->updated_at = date("Y-m-d H:i:s");
        }

        if ($isMain != $image->isMain)
        {
            if ($isMain == 1)
            {
                $imageMain = ProductImage::query()->where('product', $productId)
                    ->where('isMain', 1)->first();

                if (!empty($imageMain))
                {
                    $imageMain->isMain = 0;
                    $imageMain->save();
                }
            }

            $image->isMain = $isMain;
            $image->updated_at = date("Y-m-d H:i:s");
        }

        $image->save();

        return redirect()->route('products.show', $product)
            ->with(["message" => "success", "mes_text" => "Product's image changed!"]);
    }

    public function destroyImage($imageId)
    {
        $image = ProductImage::query()->find($imageId);

        if ($image->isMain == 1)
        {
            $newMainImage = ProductImage::query()
                ->where('product', $image->product)
                ->orderBy('position')
                ->first();
            $newMainImage->isMain = 1;
            $newMainImage->save();
        }

        Storage::disk('public')->delete($image->image);
        $image->delete();

        return redirect()->back()
            ->with(["message" => "success", "mes_text" => "Product's image removed!"]);
    }

    public function addCharOfProduct(Request $request, $productId)
    {
        $char = $request->input('char');

        if (!empty($oldChar = CharOfProduct::query()
            ->where('product', $productId)
            ->where('char', $char)
            ->first()
        ))
        {
            $oldChar->delete();
            $mes_text = "Product's feature changed!";
        }
        else
        {
            $mes_text = "Product's feature added!";
        }

        $newCharOfProduct = new CharOfProduct();
        $newCharOfProduct->product = $productId;
        $newCharOfProduct->char = $char;
        $newCharOfProduct->value = $request->input('value');
        $newCharOfProduct->numberInList = $request->input('numberInList');
        $newCharOfProduct->save();

        return redirect()->back()->with(["message" => "success", "mes_text" => $mes_text]);
    }

    public function changeCharOfProduct(Request $request, $prodCharId)
    {
        $review = CharOfProduct::query()->find($prodCharId);
        $review->numberInList = $request->input('numberInList');
        $review->save();

        return redirect()->back()->with(["message" => "success", "mes_text" => "Product's feature changed!"]);
    }

    public function removeCharOfProduct($prodCharId)
    {
        CharOfProduct::query()->find($prodCharId)->delete();

        return redirect()->back()->with(["message" => "success", "mes_text" => "Product's feature removed!"]);
    }

    public function createDiscount(Request $request, $productId)
    {
        $discount = new ProductDiscount();
        $discount->product = $productId;
        $discount->discount = $request->input('discount');
        $discount->begin_date = Carbon::createFromFormat('Y-m-d\TH:i', $request->input('begin'));
        $discount->end_date = Carbon::createFromFormat('Y-m-d\TH:i', $request->input('end'));
        $discount->save();

        return redirect()->back()->with(["message" => "success", "mes_text" => "Product's discount added!"]);
    }

    public function changeDiscount(Request $request, $discountId)
    {
        $discount = ProductDiscount::query()->find($discountId);
        $discount->discount = $request->input('discount');
        $discount->begin_date = Carbon::createFromFormat('Y-m-d\TH:i', $request->input('begin'));
        $discount->end_date = Carbon::createFromFormat('Y-m-d\TH:i', $request->input('end'));
        $discount->save();

        return redirect()->back()->with(["message" => "success", "mes_text" => "Product's discount changed!"]);
    }

    public function removeDiscount($discountId)
    {
        $discount = ProductDiscount::query()->find($discountId);
        $discount->delete();

        return redirect()->back()->with(["message" => "success", "mes_text" => "Product's discount removed!"]);
    }
}
