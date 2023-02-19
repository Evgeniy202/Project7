@extends('admin.layouts.base')
@section('title', 'Products')
@section('content')
    <form class="form-inline mt-2 mt-md-0 row mb-4" method="GET"
          action="#">
        <input name="search" id="search" class="mr-sm-2 col-md-9 bg-light" type="text" placeholder="Search"
               aria-label="Search">
        <button class="btn btn-primary my-2 my-sm-0 col-md-2" type="submit">Search</button>
        <a href="{{ route('products.index') }}"
           class="btn btn-secondary my-2 my-sm-0 col-md-1">Reset
        </a>
    </form>
    <button type="button" class="btn btn-outline-success col-md-12" data-bs-toggle="modal"
            data-bs-target="#orderDetails-">
        Add new Product
    </button>
    <div class="modal fade" id="orderDetails-" tabindex="-1" aria-labelledby="orderDetailsLabel-"
         aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content text-dark">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="orderDetailsLabel-">
                        Add new product
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
                                    <input type="text" name="title" id="title" placeholder="Title..."
                                           class="form-control">
                                </div>
                                <div class="form-group mt-3">
                                    <input type="text" name="slug" id="slug" placeholder="Marking..."
                                           class="form-control">
                                </div>
                                <div class="form-group mt-3">
                                        <textarea class="form-control" name="description" id="description" rows="10"
                                                  placeholder="Description..."></textarea>
                                </div>
                                <div class="form-group mt-3">
                                    <input type="text" name="price" id="price" placeholder="Price..."
                                           class="form-control">
                                </div>
                                <div class="form-group mt-3">
                                    <label>Is available <input type="checkbox" name="isAvailable" id="isAvailable"
                                                               value="1"></label>
                                </div>
                                <div class="form-group mt-3">
                                    <label>Is favorite <input type="checkbox" name="isFavorite" id="isFavorite"
                                                              value="1"></label>
                                </div>
                                <div class="form-group mt-3">
                                    <label>Main image <input type="file" name="mainImg" id="mainImg"></label>
                                </div>
                            </div>
                            <hr>
                            <input type="submit" class="btn btn-success btn-block col-12" value="Add">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <h3 class="col-md-10">All Products</h3>
        <hr class="mb-4">
    </div>
    <div class="row">
        <h6 class="col-md-6">Title</h6>
        <h6 class="col-md-2">Price</h6>
        <h6 class="col-md-2">Is available</h6>
        <h6 class="col-md-2">Is favorite</h6>
        <hr class="mb-4">
        @foreach($products as $product)
            <hr>
            <a href="{{ route('products.show', $product) }}"
               class="col-md-6 btn btn-warning">{{ $product->title }}</a>
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
