<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Models\CartProduct;
use App\Models\ProductDiscount;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartProductsController extends Controller
{
    public function show()
    {
        $products = CartProduct::query()
            ->join('products', 'cart_products.product', '=', 'products.id')
            ->where('cart_products.user', '=', Auth::user()->id)
            ->join('product_images', 'products.id', '=', 'product_images.product')
            ->where('product_images.isMain', 1)
            ->select('products.id',
                'cart_products.id as cart_prod_id',
                'cart_products.number',
                'products.title',
                'products.price',
                'product_images.image')
            ->get();

        $discounts = ProductDiscount::getDiscounts($products);

        return view('public.cart.cart', compact('products', 'discounts'));
    }

    public function add($productId)
    {
        if (empty(Auth::user()->id))
        {
            return redirect()->route('login');
        }

        $cartProduct = new CartProduct();
        $cartProduct->user = Auth::user()->id;
        $cartProduct->product = $productId;
        $cartProduct->number = 1;

        $exist = CartProduct::query()
            ->where('user', $cartProduct->user)
            ->where('product', $cartProduct->product)->first();

        if (!empty($exist))
        {
            $cartProduct = $exist;
            $cartProduct->number += 1;
        }

        $cartProduct->save();

        return redirect()->back()->with(['message' => 'success', 'mes_text' => 'Product has been added to your cart.']);
    }

    public function changeQuantity($cartProductId, Request $request)
    {
        $cartProduct = CartProduct::query()->find($cartProductId);
        $cartProduct->number = $request->input('number');

        $cartProduct->save();

        return redirect()->back()->with(['message' => 'success', 'mes_text' => 'Quantity changed.']);;
    }

    public function remove($cartProductId)
    {
        if (empty(Auth::user()->id))
        {
            return redirect()->route('login');
        }

        $cartProduct = CartProduct::query()->find($cartProductId);

        if ($cartProduct->user == Auth::user()->id)
        {
            $cartProduct->delete();

            return redirect()->back()
                ->with(['message' => 'success', 'mes_text' => 'Product has been removed from your cart']);
        }

        return redirect()->back()
            ->with(['message' => 'error', 'mes_text' => 'Error']);
    }

    public function cleanCart()
    {
        CartProduct::query()->where('user', Auth::user()->id)->delete();

        return redirect()->back()
            ->with(['message' => 'success', 'mes_text' => 'All product has been removed from your cart']);
    }

    public function redirectToProduct($productId)
    {
        return redirect()->route('product.show', Products::query()->find($productId));
    }
}
