<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;

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

        dd($products);
    }
}
