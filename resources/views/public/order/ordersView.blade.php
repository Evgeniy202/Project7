@extends('layouts.app')
@section('title', 'Project7 - Your Order')
@section('content')
    @if(!empty($orders[0]))
        <div class="container text-dark">
            <div class="col-12">
                <h4 style="margin-top: 10px;">Мої замовлення:</h4>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="list-orders" role="tabpanel"
                         aria-labelledby="list-orders-list">
                        <table class="table table-striped table-light">
                            <thead>
                            <tr>
                                <th scope="col">Номер</th>
                                <th scope="col">Статус</th>
                                <th scope="col">Ціна</th>
                                <th scope="col">Детально</th>
                            </tr>
                            </thead>
                            <tbody class="text-dark">
                            @foreach($orders as $order)
                                @php
                                    $productsOrder = $products->where('order', $order->id);
                                @endphp
                                <tr>
                                    <th scope="row">{{ $order->id }}</th>
                                    <td>{{ $order->status }}</td>
                                    <td>${{ $order->price }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#orderDetails-{{ $order->id }}">Більше
                                        </button>
                                    </td>
                                    <div class="modal fade" id="orderDetails-{{ $order->id }}" tabindex="-1"
                                         aria-labelledby="orderDetailsLabel-{{ $order->id }}"
                                         aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content text-dark">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-center"
                                                        id="orderDetailsLabel-{{ $order->id }}">
                                                        Інформація про замовлення №{{ $order->id }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-3 text-center mb-2">
                                                            <strong>Назва</strong>
                                                        </div>
                                                        <div class="col-md-3 text-center mb-2">
                                                            <strong>Зображення</strong>
                                                        </div>
                                                        <div class="col-md-3 text-center mb-2">
                                                            <strong>Кількість</strong>
                                                        </div>
                                                        <div class="col-md-3 text-center mb-2">
                                                            <strong>Ціна</strong>
                                                        </div>
                                                        <hr>
                                                        @foreach($productsOrder as $orderProduct)
                                                            @php
                                                                $product = 0;
                                                            @endphp
                                                            <div class="col-md-3 mb-3 text-center text-dark">
                                                                <strong>
                                                                    <a href="{{ route('redirect-to-product', $orderProduct->id) }}"
                                                                       class="text-decoration-none">
                                                                        {{ $orderProduct->title }}
                                                                    </a>
                                                                </strong>
                                                            </div>
                                                            <div class="col-md-3 mb-3 text-center">
                                                                <img
                                                                    src="{{ asset('/storage/'.$orderProduct->image) }}"
                                                                    class="img-fluid" width="50px">
                                                            </div>
                                                            <div class="col-md-3 mb-3 text-center">
                                                                {{ $orderProduct->number }} ціна
                                                            </div>
                                                            <div class="col-md-3 mb-3 text-center">
                                                                ${{ $orderProduct->price }}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <div>
                                                        <strong>Загальна ціна:</strong>
                                                        ${{ $order->price }}
                                                    </div>
                                                    <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                        Закрити
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        <h3 class="text-center">Пусто</h3>
    @endif
    <hr class="mt-5">
@endsection
