<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Models\CartProduct;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartProductsController extends Controller
{
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

    public function changeQuantity(Request $request)
    {
        $validatedData = $request->validate([
            'cartProduct_id' => 'required|exists:cartProducts,id',
            'number' => 'required',
        ]);

        $cartProduct = CartProduct::query()->find($validatedData['cartProduct_id']);
        $cartProduct->number = $validatedData['number'];

        $cartProduct->save();

        return response()->json(['status' => 'success']);
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
            return redirect()->back()
                ->with(['message' => 'success', 'mes_text' => 'Product has been removed from your cart']);
        }

        return redirect()->back()
            ->with(['message' => 'error', 'mes_text' => 'Error']);
    }
}
