@extends('layouts.app')
@section('title', 'Проект - Ваш кошик')
@section('content')
    @php
        $generalPrice = 0;
    @endphp
    <div class="container">
        @if(!empty($products[0]))
            <table class="table text-dark">
                <thead>
                <tr>
                    <th scope="col">Назва</th>
                    <th scope="col">Зображення</th>
                    <th scope="col">Ціна</th>
                    <th scope="col">Кількість</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $cartProduct)
                    @php
                        $price = $cartProduct->price * $cartProduct->number;
                        if(!empty($discounts[$cartProduct->id])) {
                            $price = $price - $discounts[$cartProduct->id];
                        }

                        $generalPrice += $price;
                    @endphp
                    <tr>
                        <th scope="row"><a
                                href="{{ route('redirect-to-product', $cartProduct->id) }}">{{ $cartProduct->title }}</a>
                        </th>
                        <td><a href="{{ route('redirect-to-product', $cartProduct->id) }}"><img
                                    src="{{ asset('/storage/'.$cartProduct->image) }}"
                                    class="img-fluid rounded" style="width: 50px"></a></td>
                        <td>${{ $price }}</td>
                        <td>
                            <form action="{{ route('change-quantity', $cartProduct->cart_prod_id) }}"
                                  method="POST">
                                @csrf
                                <input type="number" class="form-control col-md-12" name="number" min="1"
                                       value="{{ $cartProduct->number }}">
                                <br>
                                <input type="submit" class="btn btn-primary col-md-12" value="Змінити кількість">
                            </form>
                            <a href="{{ route('remove-from-cart', $cartProduct->cart_prod_id) }}"
                               class="btn btn-danger col-md-12 mt-2">Видалити</a>
                        </td>
                @endforeach
                </tbody>
            </table>
            <h5>Загальна вартість: ${{ $generalPrice }}</h5>
            <hr>
            <div class="">
                <button id="show_order" class="btn btn-outline-success col-7 m-1">Замовити</button>
                <a href="{{ route('all-remove-from-cart') }}" class="btn btn-outline-danger col-4 m-1">Очистити кошик</a>
            </div>
            <form id="order_form" method="post" action="{{ route('check-order') }}" hidden>
                <hr>
                @csrf
                <div class="mt-2">
                    <input id="name" name="name" type="text" class="form-control"
                           placeholder="Ім'я та прізвище отримувача...">
                </div>
                <div class="mt-2">
                    <input id="phone" name="phone" type="text" class="form-control" placeholder="Номер телефону...">
                </div>
                <div class="mt-2">
                    <input id="address" name="address" type="text" class="form-control"
                           placeholder="Адреса або поштовий індекс...">
                </div>
                <div class="mt-2">
                    <textarea id="comment" name="comment" class="form-control" rows="10"
                              placeholder="Коментар (необов'язково)..."></textarea>
                </div>
                <input id="generalPrice" name="generalPrice" type="text" class="visually-hidden"
                       value="{{ $generalPrice }}" readonly>
                <div class="mt-2">
                    <button type="submit" class="btn btn-outline-success col-9 m-2">Відправити</button>
                    <button type="button" id="hide_order" class="btn btn-outline-secondary col-2 m-2">Закрити</button>
                </div>
            </form>
            <script src="js/order/form.js"></script>
        @else
            <h3 class="text-center">Пусто</h3>
        @endif
    </div>
@endsection
