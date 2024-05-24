@extends('admin.layouts.base')
@section('title', 'Products')
@section('content')
    <form class="form-inline mt-2 mt-md-0 row mb-4" method="POST"
          action="{{ route('searchProductsAdmin') }}">
        @csrf
        <input name="search" id="search" class="mr-sm-2 col-md-9 bg-light" type="text" placeholder="Search"
               aria-label="Search" required>
        <button class="btn btn-primary my-2 my-sm-0 col-md-2" type="submit">Пошук</button>
        <a href="{{ route('products.index') }}"
           class="btn btn-secondary my-2 my-sm-0 col-md-1">Скинути
        </a>
    </form>
    <button type="button" class="btn btn-outline-success col-md-12" data-bs-toggle="modal"
            data-bs-target="#orderDetails-">
        Додати новий товар
    </button>
    <div class="modal fade" id="orderDetails-" tabindex="-1" aria-labelledby="orderDetailsLabel-"
         aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content text-dark">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="orderDetailsLabel-">
                        Додати новий товар
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mt-3">
                                <select class="form-control text-center btn-outline-secondary" name="category">
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                                <div class="form-group mt-3">
                                    <input type="text" name="title" id="title" placeholder="Назва..."
                                           class="form-control">
                                </div>
                                <div class="form-group mt-3">
                                    <input type="text" name="slug" id="slug" placeholder="Маркування..."
                                           class="form-control">
                                </div>
                                <div class="form-group mt-3">
                                        <textarea class="form-control" name="description" id="description" rows="10"
                                                  placeholder="Опис..."></textarea>
                                </div>
                                <div class="form-group mt-3">
                                    <input type="text" name="price" id="price" placeholder="Ціна..."
                                           class="form-control">
                                </div>
                                <div class="form-group mt-3">
                                    <label>В наявності <input type="checkbox" name="isAvailable" id="isAvailable"
                                                               value="1"></label>
                                </div>
                                <div class="form-group mt-3">
                                    <label>Рекомендоване <input type="checkbox" name="isFavorite" id="isFavorite"
                                                              value="1"></label>
                                </div>
                                <div class="form-group mt-3">
                                    <label>Головне зображення <input type="file" name="mainImg" id="mainImg"></label>
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
    <div class="row">
        <h3 class="col-md-10">Всі товари</h3>
        <hr class="mb-4">
    </div>
    <div class="row">
        <h6 class="col-md-4">Назва</h6>
        <h6 class="col-md-2">Кількість</h6>
        <h6 class="col-md-2">Ціна</h6>
        <h6 class="col-md-2">В наявності</h6>
        <h6 class="col-md-2">Рекомендоване</h6>
        <hr class="mb-4">
        @foreach($products as $product)
            <hr>
            <a href="{{ route('products.show', $product) }}"
               class="col-md-4 btn btn-warning">{{ $product->title }}</a>
            <p class="col-md-2">{{ $product->count }}</p>
            <p class="col-md-2">{{ $product->price }}$</p>
            <strong class="col-md-2">
                @if($product->isAvailable == 1)
                    +
                @else
                    -
                @endif
            </strong>
            <strong class="col-md-2">
                @if($product->isFavorite == 1)
                    +
                @else
                    -
                @endif
            </strong>
        @endforeach
        <div class="d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </div>
@endsection
