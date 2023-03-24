<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Models\CartProduct;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\ProductDiscount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkOrder(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $order = new Order();
        $order->user = Auth::user()->id;
        $order->status = 'New';
        $order->name = $validateData['name'];
        $order->phone = $validateData['phone'];
        $order->address = $validateData['address'];
        $order->comment = $request->input('comment') ?? null;
        $order->price = 0;
        $order->save();

        $generalPrice = 0;

        $cartProducts = CartProduct::query()->where('user', Auth::user()->id);

        $products = CartProduct::query()
            ->join('products', 'cart_products.product', '=', 'products.id')
            ->where('cart_products.user', '=', Auth::user()->id)
            ->join('product_images', 'products.id', '=', 'product_images.product')
            ->where('product_images.isMain', 1)
            ->select('products.id',
                'cart_products.id as cart_prod_id',
                'cart_products.number',
                'products.price',
                'product_images.image')
            ->get();

        $discounts = ProductDiscount::getDiscounts($products);

        foreach ($products as $product)
        {
            $orderProduct = new OrderProduct();
            $orderProduct->user = Auth::user()->id;
            $orderProduct->order = $order->id;
            $orderProduct->product = $product->id;
            $orderProduct->number = $product->number;

            if (!empty($discounts[$product->id]))
            {
                $orderProduct->price = ($product->price * $product->number) - ($discounts[$product->id] * $product->number);
            }
            else
            {
                $orderProduct->price = $product->price * $product->number;
            }

            $orderProduct->save();

            $generalPrice += $orderProduct->price;
        }

        $cartProducts->delete();
        $order->price = $generalPrice;
        $order->save();

        return redirect()->route('home')
            ->with(['message' => 'success', 'mes_text' => 'Success! The manager will contact you shortly.']);
    }

    public function orderView()
    {
        $orders = Order::query()->where('user', Auth::user()->id)->get();
        $products = OrderProduct::query()
            ->join('products', 'order_products.product', '=', 'products.id')
            ->where('order_products.user', '=', Auth::user()->id)
            ->join('product_images', 'products.id', '=', 'product_images.product')
            ->where('product_images.isMain', 1)
            ->select('products.id',
                'products.title',
                'order_products.id as order_prod_id',
                'order_products.order',
                'order_products.number',
                'order_products.price',
                'product_images.image')
            ->get();

        return view('public.order.ordersView', compact('orders', 'products'));
    }
}
