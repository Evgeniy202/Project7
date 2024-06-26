@extends('admin.layouts.base')
@section('title')
    Адмін - Продукт №{{ $product->id }}
@endsection
@section('content')
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <h1>Продукт - {{ $product->title }}</h1>
    <hr class="mt-2">
    <div class="row">
        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group mt-3">
                <div class="form-group mt-3">
                    <label>Назва:</label>
                    <input type="text" name="title" id="title" placeholder="Назва..."
                           class="form-control bg-dark text-light" value="{{ $product->title }}">
                </div>
                <div class="form-group mt-3">
                    <input type="text" name="slug" id="slug" placeholder="Маркування..."
                           class="form-control bg-dark text-light" value="{{ $product->slug }}">
                </div>
                <div class="form-group mt-3">
                    <textarea class="form-control bg-dark text-light" name="description" id="description" rows="10"
                              placeholder="Опис...">{{ $product->description }}</textarea>
                </div>
                <div class="form-group mt-3">
                                    <label>Ціна:</label><input type="text" name="price" id="price" placeholder="Ціна..."
                                        class="form-control bg-dark text-light" value="{{ $product->price }}">
                                </div>
                                <div class="form-group mt-3">
                                    <label>Кількість:</label><input type="number" name="count" id="count" placeholder="Кількість..."
                                        class="form-control bg-dark text-light" value="{{ $product->count }}">
                                </div>
                                <div class="form-group mt-3">
                                    @if($product->isAvailable == 1)
                                        <label>Доступний <input type="checkbox" name="isAvailable" id="isAvailable"
                                                                value="1" checked></label>
                                    @else
                                        <label>Доступний <input type="checkbox" name="isAvailable" id="isAvailable"
                                                                value="1"></label>
                                    @endif
                                </div>
                                <div class="form-group mt-3">
                                    @if($product->isFavorite == 1)
                                        <label>Улюблений <input type="checkbox" name="isFavorite" id="isFavorite"
                                                                value="1" checked></label>
                                    @else
                                        <label>Улюблений <input type="checkbox" name="isFavorite" id="isFavorite"
                                                                value="1"></label>
                                    @endif
                                </div>
                            </div>
                            <input type="submit" class="btn btn-outline-warning btn-block col-md-12" value="Змінити">
                        </form>
                        <hr class="mt-2">
                        <hr>
                        <button type="button" class="btn btn-outline-success col-md-12" data-bs-toggle="modal"
                                data-bs-target="#createDiscount-">
                            Додати нову знижку
                        </button>
                        <div class="modal fade" id="createDiscount-" tabindex="-1" aria-labelledby="createDiscountLabel-"
                            aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content text-dark">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-center" id="createDiscountLabel-">
                                            Додати нову знижку
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <form action="{{ route('create-discount', $product->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group mt-3">
                                                    <div class="form-group mt-3">
                                                        <input type="text" id="discount" name="discount" placeholder="Знижка..."
                                                            required>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <label for="start_date">Дата початку:</label>
                                                        <input type="datetime-local" id="begin" name="begin" required>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <label for="end_date">Дата закінчення:</label>
                                                        <input type="datetime-local" id="end" name="end" required><br><br>
                                                    </div>
                                                </div>
                                                <hr>
                                                <input type="submit" class="btn btn-success btn-block col-12" value="Додати">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Знижка</th>
                                <th scope="col">Ціна зі знижкою</th>
                                <th scope="col">Дата - початок</th>
                                <th scope="col">Дата - кінець</th>
                                <th scope="col">Дії</th>
                            </tr>
                            </thead>
                            <tbody>                
            @foreach($productDiscounts as $discount)
                <tr>
                    <th scope="row">{{ $discount->discount }}$</th>
                    <th scope="row">{{ $product->price - $discount->discount }}$</th>
                    <td>{{ $discount->begin_date }}</td>
                    <td>{{ $discount->end_date }}</td>
                    <td>
                        <button class="btn btn-warning col-5" data-bs-toggle="modal"
                                data-bs-target="#changeModal-{{ $discount->id }}">Змінити знижку
                        </button>
                        <div class="modal fade" id="changeModal-{{ $discount->id }}" tabindex="-1"
                             aria-labelledby="changeModalLabel-{{ $discount->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header text-dark">
                                        <h5 class="modal-title text-center"
                                            id="changeModalLabel-{{ $discount->id }}">
                                            <strong>Змінити знижку</strong>
                                        </h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <form action="{{ route('change-discount', $discount->id) }}" method="POST"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group mt-3">
                                                    <div class="form-group mt-3">
                                                        <input type="text" id="discount" name="discount"
                                                               placeholder="Знижка..."
                                                               value="{{ $discount->discount }}"
                                                               required>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <label for="start_date">Дата початку:</label>
                                                        <input type="datetime-local" id="begin" name="begin"
                                                               value="{{ $discount->begin_date }}"
                                                               required>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <label for="end_date">Дата кінця:</label>
                                                        <input type="datetime-local" id="end" name="end"
                                                               value="{{ $discount->end_date }}"
                                                               required>
                                                    </div>
                                                </div>
                                                <hr>
                                                <input type="submit" class="btn btn-warning btn-block col-12"
                                                       value="Змінити">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-danger col-5" data-bs-toggle="modal"
                                data-bs-target="#removeModal-{{ $discount->id }}">Видалити знижку
                        </button>
                        <div class="modal fade" id="removeModal-{{ $discount->id }}" tabindex="-1"
                             aria-labelledby="removeModalLabel-{{ $discount->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header text-dark">
                                        <h5 class="modal-title text-center"
                                            id="removeModalLabel-{{ $discount->id }}">
                                            <strong>Видалити знижку</strong>
                                        </h5>
                                    </div>
                                    <div class="modal-body text-dark">
                                        <div>
                                            Ви впевнені, що хочете видалити цю знижку?
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <a href="{{ route('remove-discount', $discount->id) }}"
                                           class="btn btn-outline-danger">Видалити</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
        <hr class="mt-2">
        <hr>
        <button type="button" class="btn btn-outline-success col-md-12" data-bs-toggle="modal"
                data-bs-target="#orderDetails-">
            Додати нове зображення
        </button>
        <div class="modal fade" id="orderDetails-" tabindex="-1" aria-labelledby="orderDetailsLabel-"
             aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content text-dark">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="orderDetailsLabel-">
                            Додати нове зображення
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form action="{{ route('addProductImage', $product->id) }}" method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="form-group mt-3">
                                    <div class="form-group mt-3">
                                        <label>Зображення <input type="file" name="image" id="image" required></label>
                                    </div>
                                    <div class="form-group mt-3">
                                        <input class="col-12" type="text" name="position" id="position"
                                               placeholder="Позиція...">
                                    </div>
                                </div>
                                <hr>
                                <input type="submit" class="btn btn-success btn-block col-12" value="Додати">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach($imagesOfProduct as $image)
            <hr class="mt-2">
            <div class="form-group mt-3">
                <button class="btn btn-outline-" type="button" data-bs-toggle="modal"
                        data-bs-target="#imageDetails-{{ $image->id }}">
                    <img src="{{ asset('/storage/'.$image->image) }}"
                         alt="{{ $product->title }}_{{ $image->position }}">
                </button>
                <div class="modal fade" id="imageDetails-{{ $image->id }}" tabindex="-1"
                     aria-labelledby="imageDetailsLabel-{{ $image->id }}"
                     aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content text-dark">
                            <div class="modal-header bg-dark">
                                <h5 class="modal-title text-light text-center" id="imageDetails-{{ $image->id }}">
                                    Зображення: {{ $product->title }}_{{ $image->position }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body bg-dark">
                                <div class="row text-light">
                                    <img src="{{ asset('/storage/'.$image->image) }}"
                                         alt="{{ $product->title }}_{{ $image->position }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('changeProductImage', [$product->id, $image->id]) }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="form-group mt-3">
                    <label class="col">Позиція<input type="text" name="position" id="position"
                                                      placeholder="Позиція..."
                                                      class="form-control bg-dark text-light"
                                                      value="{{ $image->position }}"></label>
                </div>
                <div class="form-group mt-3">
                    @if($image->isMain == 1)
                        <label>Головне<input type="checkbox" name="isMain" id="isMain"
                                             value="1" checked></label>
                    @else
                        <label>Головне<input type="checkbox" name="isMain" id="isMain"
                                             value="1"></label>
                    @endif
                </div>
                <input type="submit" class="btn btn-warning col-2" value="Замінити зображення">
            </form>
            <div class="container">
                <button class="btn btn-danger col-2" data-bs-toggle="modal"
                        data-bs-target="#removeModal-{{ $image->id }}">Видалити зображення
                </button>
            </div>
            <div class="modal fade" id="removeModal-{{ $image->id }}" tabindex="-1"
                 aria-labelledby="removeModalLabel-{{ $image->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header text-dark">
                            <h5 class="modal-title text-center"
                                id="removeModalLabel-{{ $image->id }}">
                                <strong>Видалити зображенняe</strong>
                            </h5>
                        </div>
                        <div class="modal-body text-dark">
                            <div>
                                Ви впевнені, що хочете видалити це зображення?
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Закрити
                            </button>
                            <a href="{{ route('destroyProductImage', [$image->id]) }}"
                               class="btn btn-outline-danger">Видалити</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <hr class="mt-2">
        <hr>
        <button type="button" class="btn btn-outline-success col-md-9" data-bs-toggle="modal"
                data-bs-target="#newProdChar-">
            Додати або змінити характеристику
        </button>
        <a href="{{ route('featuresOfCategory', $product->category) }}" target="_blank"
           class="btn btn-outline-warning col-md-3">
            Управління характеристиками
        </a>
        <hr class="mt-3 mb-3">
    </div>
    <div class="modal fade" id="newProdChar-" tabindex="-1" aria-labelledby="newProdCharLabel-"
         aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content text-dark">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="newProdCharLabel-">
                        Додати або змінити характеристику
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form action="{{ route('addProductFeature', $product->id) }}" method="POST">
                            @csrf
                            <div class="form-group mt-3 text-dark">
                                <select name="char" class="form-control text-center" id="char">
                                    <option>-Обрати характеристику-</option>
                                    @foreach ($featuresOfCategory as $char)
                                        <option value="{{ $char->id }}"
                                                data-class="{{ $char->id }}">{{ $char->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mt-3">
                                <select name="value" class="form-control text-center" id="value">
                                </select>
                            </div>
                            <div class="form-group mt-3">
                                <input type="text" name="numberInList" id="numberInList"
                                       placeholder="Порядок в списку"
                                       class="form-control text-center">
                            </div>
                            <hr>
                            <input type="submit" class="btn btn-success btn-block col-12"
                                   value="Додати або змінити характеристику">
                            <script src="/js/ajax/admin/valueOfFeature.js"></script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Порядок в списку</th>
            <th scope="col">Характеристика</th>
            <th scope="col">Значення</th>
            <th scope="col">Видалити</th>
        </tr>
        </thead>
        <tbody>
        @foreach($featuresView as $featureView)
            <tr>
                <th scope="row">{{ $featureView['numberInList'] }}</th>
                <td>{{ $featureView['feature'] }}</td>
                <td>{{ $featureView['value'] }}</td>
                <td>
                    <button class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#changeModal-{{ $featureView['feature'] }}">Змінити порядок в списку
                    </button>
                    <div class="modal fade" id="changeModal-{{ $featureView['feature'] }}" tabindex="-1"
                         aria-labelledby="changeModalLabel-{{ $featureView['feature'] }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-dark">
                                    <h5 class="modal-title text-center"
                                        id="changeModalLabel-{{ $featureView['feature'] }}">
                                        <strong>Змінити порядок в списку для {{ $featureView['feature'] }}</strong>
                                    </h5>
                                </div>
                                <div class="modal-body text-dark">
                                    <div>
                                        <form
                                            action="{{ route('changeProductFeature', [$featureView['charOfProd']]) }}"
                                            method="POST">
                                            @csrf
                                            <input type="text" placeholder="Number" id="numberInList"
                                                   name="numberInList"
                                                   value="{{ $featureView['numberInList'] }}" required>
                                            <input type="submit" class="btn btn-warning" value="Змінити">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#removeModal-{{ $featureView['feature'] }}">Видалити
                    </button>
                    <div class="modal fade" id="removeModal-{{ $featureView['feature'] }}" tabindex="-1"
                         aria-labelledby="removeModalLabel-{{ $featureView['feature'] }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-dark">
                                    <h5 class="modal-title text-center"
                                        id="removeModalLabel-{{ $featureView['feature'] }}">
                                        <strong>Видалити {{ $featureView['feature'] }}</strong>
                                    </h5>
                                </div>
                                <div class="modal-body text-dark">
                                    <div>
                                        Ви впевнені, що хочете видалити характеристику "{{ $featureView['feature'] }}"?
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Закрити
                                    </button>
                                    <a href="{{ route('destroyProductFeature', [$featureView['charOfProd']]) }}">
                                        <button type="button" class="btn btn-outline-danger">Видалити
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
