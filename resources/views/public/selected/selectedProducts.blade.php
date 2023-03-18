@extends('layouts.app')
@section('title', 'Project - Selected Products')
@section('content')
    <main class="container">
        <header class="d-sm-flex align-items-center border-bottom mb-4 pb-3">
            @if(!empty($products))
                @if(count($products) < 2)
                    <strong class="d-block py-2">{{ count($products) }} product</strong>
                @elseif(count($products) > 1)
                    <strong class="d-block py-2">{{ count($products) }} products</strong>
                @endif
            @else
                <strong class="d-block py-2">0 products</strong>
            @endif
        </header>
        <!-- ========= content items ========= -->
        @if(empty($products))
            <h3 class="text-center">Empty</h3>
        @else
            @foreach($products as $product)
                <article class="card card-product-list m-4">
                    <div class="row g-0">
                        <aside class="col-xl-3 col-md-4">
                            <a href="{{ route('product.show', $product) }}"
                               class="img-wrap rounded bg-gray-light"> <img height="100"
                                                                            class="mix-blend-multiply mt-4 m-5 rounded"
                                                                            src="{{ asset('/storage/'.$images[$product->id]) }}">
                            </a>
                        </aside> <!-- col.// -->
                        <div class="col-lg-6 col-md-5 col-sm-7">
                            <div class="card-body">
                                <a href="{{ route('product.show', $product) }}"
                                   class="title h5"> {{ $product->title }} </a>

                                <div class="rating-wrap mb-2">
                                    <i class="dot"></i>
                                </div> <!-- rating-wrap.// -->
                                <p class="text-dark">{{ $product->description }}</p>
                            </div> <!-- card-body.// -->
                        </div> <!-- col.// -->
                        <aside class="col-xl-3 col-md-3 col-sm-5">
                            <div class="info-aside">
                                <div class="price-wrap pt-1">
                                    @if (!empty($discounts[$product->id]))
                                        <strong class="price">${{ $product->price - $discounts[$product->id] }} with
                                            discount!</strong>
                                        <br>
                                        <del class="price-old"> ${{ $product->price }}</del>
                                    @else
                                        <strong class="price"> ${{ $product->price }} </strong>
                                    @endif
                                </div> <!-- info-price-detail // -->
                                <div class="mb-3">
                                    <a href="#"
                                       class="btn btn-outline-primary col-8 m-1"> Add to cart </a>
                                    <a href="{{ route('remove-selected', $product->id) }}"
                                       class="btn btn-outline-danger col-8 m-1"> Remove from selected </a>
                                </div>
                            </div> <!-- info-aside.// -->
                        </aside> <!-- col.// -->
                    </div> <!-- row.// -->
                </article>
            @endforeach
        @endif
        <hr>
    </main>
@endsection
