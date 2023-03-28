<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\ProductDiscount;
use App\Models\Products;
use Illuminate\Http\Request;
use Mockery\Exception;

class OrderController extends Controller
{
    public function ordersList($status)
    {
        $ordersList = Order::query()
            ->where('status', $status)
            ->orderBy('updated_at', 'asc')
            ->paginate(20);

        return view('admin.orders.ordersList', [
            'ordersList' => $ordersList ?? collect(),
            'status' => $status,
        ]);
    }

    public function search(Request $request)
    {
        if (!empty($request->input('search')))
        {
            $data = $request->validate(['search' => 'numeric|required']);
            $ordersList = Order::query()
                ->where('id', $data['search'])
                ->orderBy('updated_at', 'asc')
                ->paginate(20);
        }

        return view('admin.orders.search', [
            'ordersList' => $ordersList ?? collect(),
        ]);
    }

    public function show($orderId)
    {
        $order = Order::query()->find($orderId);

        $products = OrderProduct::query()
            ->join('products', 'order_products.product', '=', 'products.id')
            ->where('order_products.order', '=', $order->id)
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

        return view('admin.orders.detail', compact('order', 'products',));
    }

    public function changeStatus($orderId, $status)
    {
        $order = Order::query()->find($orderId);
        $order->status = $status;
        $order->save();

        return redirect()->route('order-detail', $orderId)->with([
            'message' => 'success',
            'mes_text' => 'Status has been change on "'. $status .'"',
        ]);
    }

    public function changeNumber($orderProductId, Request $request)
    {
        $number = $request->input('number');
        $product = OrderProduct::query()->find($orderProductId);
        $order = Order::query()->find($product->order);

        $newPrice = ($product->price / $product->number) * $number;
        $order->price = $order->price - $product->price + $newPrice;

        try
        {
            $product->number = $number;
            $product->price = $newPrice;
            $product->save();
            $order->save();

            return redirect()->route('order-detail', $order->id)->with([
                'message' => 'success',
                'mes_text' => 'Quantity has been change.',
            ]);
        }
        catch (Exception $e)
        {
            return redirect()->route('order-detail', $order->id)->with([
                'message' => 'error',
                'mes_text' => 'Quantity has not been change.',
            ]);
        }
    }

    public function removeProduct($orderProductId)
    {
        $product = OrderProduct::query()->find($orderProductId);
        $order = Order::query()->find($product->order);
        $order->price = $order->price - $product->price;
        $order->save();
        $product->delete();

        return redirect()->route('order-detail', $order->id)->with([
            'message' => 'success',
            'mes_text' => 'Product has been remove.',
        ]);
    }

    public function addProduct($orderId, Request $request)
    {
        $query = $request->input('search');
        $product = Products::query()
            ->where('title', $query)
            ->orWhere('slug', $query)
            ->first();

        if (empty($product))
        {
            return redirect()->route('order-detail', $orderId)->with([
                'message' => 'error',
                'mes_text' => 'Product has not been search.',
            ]);
        }

        if ($product->count < 1)
        {
            return redirect()->route('order-detail', $orderId)->with([
                'message' => 'error',
                'mes_text' => 'This product is out of stock.',
            ]);
        }

        $order = Order::query()->find($orderId);
        $discount = ProductDiscount::getDiscount($product);

        $orderProduct = new OrderProduct();
        $orderProduct->user = $order->user;
        $orderProduct->order = $order->id;
        $orderProduct->product = $product->id;
        $orderProduct->number = 1;

        if (!empty($discount))
        {
            $orderProduct->price = $product->price - $discount;
        }
        else
        {
            $orderProduct->price = $product->price;
        }

        $orderProduct->save();
        $product->count -= $product->number;
        $product->save();
        $order->price += $orderProduct->price;
        $order->save();

        return redirect()->route('order-detail', $orderId)->with([
            'message' => 'success',
            'mes_text' => 'This product "' . $product->title . '" added.',
        ]);
    }
}
