<?php

namespace App\Http\Controllers\Open;

use App\Functions\Sessions\GetCategories;
use App\Http\Controllers\Controller;
use App\Models\ProductDiscount;
use App\Models\ProductImage;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\Selected;
use Illuminate\Support\Facades\Auth;

class SelectedProductsController extends Controller
{
    public function action(Request $request)
    {
        if (empty(Auth::user()->id))
        {
            return redirect()->route('login');
        }

        $userId = Auth::user()->id;
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $selected = new Selected();
        $selected->user = $userId;
        $selected->product = $validatedData['product_id'];

        $coincidence = Selected::query()
            ->where('user', $selected->user)
            ->where('product', $selected->product)
            ->first();

        if (empty($coincidence))
        {
            $selected->save();
        }
        else
        {
            $coincidence->delete();
        }

        return response()->json(['status' => 'success', 'selected' => $selected]);
    }

    public function show()
    {
        $selected = Selected::query()
            ->where('user', Auth::user()->id)
            ->pluck('product')->toArray();
        $products = Products::query()
            ->whereIn('id', $selected)
            ->get();

        if (!empty($products))
        {
            $images = ProductImage::getMainImages($products);
            $discounts = ProductDiscount::getDiscounts($products);
        }

        return view('public.selected.selectedProducts', [
            'products' => $products,
            'images' => $images ?? null,
            'discounts' => $discounts ?? null,
        ]);
    }

    public function remove($productId)
    {
        Selected::query()->where('user', Auth::user()->id)->where('product', $productId)->delete();

        return redirect()->back()
            ->with(['message' => 'success', 'mes_text' => 'The product has been removed from favorites.']);
    }
}
