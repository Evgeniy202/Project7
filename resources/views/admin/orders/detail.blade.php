@extends('admin.layouts.base')
@section('title')
    Адмін - Замовлення №{{ $order->id }}
@endsection
@section('content')
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <div class="container">
        <h3>Замовлення №{{ $order->id }}</h3>
        <hr>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" role="tabpanel"
                aria-labelledby="list-orders-list">
                <table class="table text-dark">
                    <div class="row">
                        <thead>
                        <tr>
                            <th class="col-md-2">Номер</th>
                            <th class="col-md-2">Статус</th>
                            <th class="col-md-2">Ціна</th>
                            <th class="col-md-2">Створено</th>
                            <th class="col-md-2">Оновлено</th>
                        </tr>
                        </thead>
                        <tbody class="text-dark">
                        <tr>
                            <td class="col-md-2">№{{ $order->id }}</td>
                            <td class="col-md-2">
                                <select class="bg-light text-dark" name="status" id="status">
                                    <option value="{{ $order->status }}">{{ $order->status }}</option>
                                    @switch($order->status)
                                        @case('New')
                                        <option value="Processing">В обробці</option>
                                        <option value="Sent">Відправлено</option>
                                        <option value="Executed">Виконано</option>
                                        <option value="Canceled">Скасовано</option>
                                        @break
                                        @case('Processing')
                                        <option value="New">Нове</option>
                                        <option value="Sent">Відправлено</option>
                                        <option value="Executed">Виконано</option>
                                        <option value="Canceled">Скасовано</option>
                                        @break
                                        @case('Sent')
                                        <option value="New">Нове</option>
                                        <option value="Processing">В обробці</option>
                                        <option value="Executed">Виконано</option>
                                        <option value="Canceled">Скасовано</option>
                                        @break
                                        @case('Executed')
                                        <option value="New">Нове</option>
                                        <option value="Processing">В обробці</option>
                                        <option value="Sent">Відправлено</option>
                                        <option value="Canceled">Скасовано</option>
                                        @break
                                        @case('Canceled')
                                        <option value="New">Нове</option>
                                        <option value="Processing">В обробці</option>
                                        <option value="Sent">Відправлено</option>
                                        <option value="Executed">Виконано</option>
                                        @break
                                    @endswitch
                                </select>
                                <script>
                                    $('#status').on('change', function () {
                                        var status = $(this).val();
                                        if (status) {
                                            window.location.replace('/admin/change-status/{{ $order->id }}/' + status);
                                        }
                                    });
                                </script>
                            </td>
                            <td class="col-md-2">{{ $order->price }}</td>
                            <td class="col-md-2">{{ $order->created_at }}</td>
                            <td class="col-md-2">{{ $order->updated_at }}</td>
                        </tr>
                        </tbody>
                    </div>
                </table>
            </div>
            <div class="row">
                <hr>
                <strong class="col-md-2">Ім'я:</strong>
                <strong class="col-md-10">{{ $order->name }}</strong>
                <hr class="mt-3">
                <strong class="col-md-2">Мобільний номер:</strong>
                <strong class="col-md-10">{{ $order->phone }}</strong>
                <hr class="mt-3">
                <strong class="col-md-2">Адреса:</strong>
                <strong class="col-md-10">{{ $order->address }}</strong>
                <hr class="mt-3">
            </div>
            <h6>Коментар:</h6>
            @if(!empty($order->comment))
                {{ $order->comment }}
            @else
                Пусто...
            @endif
            <hr class="mt-3">
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
                @foreach($products as $product)
                    <tr>
                        <th scope="row"><a
                                href="{{ route('redirect-to-product', $product->id) }}">{{ $product->title }}</a>
                        </th>
                        <td><a href="{{ route('redirect-to-product', $product->id) }}"><img
                                    src="{{ asset('/storage/'.$product->image) }}"
                                    class="img-fluid rounded" width="50px"></a></td>
                        <td>${{ $product->price }}</td>
                        <td>
                            <form action="{{ route('change-number', $product->order_prod_id) }}"
                                method="POST">
                                @csrf
                                <input type="number" class="form-control col-md-12" name="number" min="1"
                                    value="{{ $product->number }}">
                                <br>
                                <input type="submit" class="btn btn-primary col-md-12" value="Змінити кількість">
                            </form>
                            <a href="{{ route('remove-orderProduct', $product->order_prod_id) }}"
                            class="btn btn-danger col-md-12 mt-2">Видалити</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <button id="show_form" class="btn btn-outline-success col-12">Додати новий
            продукт
        </button>
        <form id="add_form" method="post" action="{{ route('add-product', $order->id) }}" hidden>
            <hr>
            @csrf
            <div class="mt-2">
                <input name="search" id="search" class="mr-sm-2 bg-light form-control" type="text"
                    placeholder="Пошук за номером замовлення"
                    aria-label="Search" required>
            </div>
            <div class="mt-2">
                <button type="submit" class="btn btn-outline-success col-9 m-2">Пошук</button>
                <button type="button" id="hide_form" class="btn btn-outline-secondary col-2 m-2">Закрити</button>
            </div>
        </form>
        <script src="/js/admin/orders/showForm.js"></script>
@endsection
