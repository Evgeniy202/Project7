@extends('layouts.app')
@section('title')
    Project7 - {{ $product->title }}
@endsection
@section('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"/>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
@endsection
@section('content')
    @if (!empty(Auth::user()->id))
        <script
            src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"
        ></script>
        <script>
            $(document).ready(function () {
                $('.select-btn').on('click', function () {
                    var productId = $(this).data('product-id');

                    $.ajax({
                        url: '{{ route('select-product') }}',
                        method: 'POST',
                        data: {
                            product_id: productId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function () {
                            btnStyle();
                        },
                    });

                    function btnStyle() {
                        const button = document.getElementById('selectBtn-' + productId);

                        if (button.classList.contains('active')) {
                            button.classList.remove('active');
                        } else {
                            button.classList.add('active');
                        }
                    }
                });
            });
        </script>
    @endif
    <div class="container text-dark">
        <div class="row">
            <div class="col-md-4">
                <div class="main-img-slider">
                    <a data-fancybox="gallery" href="{{ asset('/storage/'.$images[0]->image) }}">
                        <img src="{{ asset('/storage/'.$images[0]->image) }}"
                             class="img-fluid w-100 rounded">More Images</a>
                </div>
            </div>
            <div class="col-md-8">
                <h3> {{ $product->title }} </h3>
                <p>Price: @if (!empty($discount))
                        <strong class="price text-danger">${{ $product->price - $discount }} with
                            discount!</strong>
                        <br>
                        <del class="price-old"> ${{ $product->price }}</del>
                    @else
                        <strong class="price"> ${{ $product->price }} </strong>
                    @endif
                </p>
                <p>Description: {{ $product->description }} </p>
                <hr>
                @if(!empty(Auth::user()->id))
                    @php
                        $active = null;
                        if ($selected)
                        {
                            $active = 'active';
                        }
                    @endphp
                    <button id="selectBtn-{{ $product->id }}"
                            data-product-id="{{ $product->id }}"
                            class="btn btn-outline-danger select-btn {{ $active }}">
                        Add to selected
                    </button>
                    <a href="{{ route('add-to-cart', $product->id) }}" class="btn btn-outline-success">Add to cart</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-danger">Add to selected</a>
                    <a href="{{ route('login') }}" class="btn btn-outline-success">Add to cart</a>
                @endif
            </div>
            <hr>
            <h4>Features:</h4>
            <table class="table">
                <tbody>
                @foreach($features as $feature)
                    <tr>
                        <th scope="row">{{ $feature['feature'] }}:</th>
                        <td>{{ $feature['value'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <hr>

            {{--            comment in future--}}

        </div>
        <div class="row">
            <section id="detail">
                <div class="main-img-slider">
                    @for($i = 1; $i < count($images); $i++)
                        <a data-fancybox="gallery" href="{{ asset('/storage/'.$images[$i]->image) }}">
                            <img src="{{ asset('/storage/'.$images[$i]->image) }}" class="img-fluid"
                                 style="display: none;">
                        </a>
                    @endfor
                </div>
            </section>
            <script src="/js/products/imagesCarusel.js"></script>
        </div>
        <h3 class="mb-2">Comments:</h3>
        @if (!empty(Auth::user()->id))
            <div class="text-light">
                <div class="col-md-12">
                    <h3 class=""></h3>
                    <form action="{{ route('add-comment', $product->id) }}" method="POST" class="p-5">
                        @csrf
                        <input type="text" id="name" name="name" class="form-control m-2" placeholder="You name"
                               required>
                        <textarea id="comment" name="comment" class="form-control m-2" rows="5"
                                  placeholder="You comment" required></textarea>
                        <input type="submit" class="btn btn-outline-success m-2 col-12" value="Add comment">
                    </form>
                </div>
            </div>
            <hr>
        @endif
        @if(!empty($comments->first()))
            @foreach($comments as $comment)
                <div class="comment mt-4 text-justify float-left">
                    <hr style="margin-right: 60%;">
                    <h6>{{ $comment->name }} <span>- {{ $comment->created_at }}</span></h6>
                    <br>
                    <p>{{ $comment->comment }}</p>
                    <hr style="margin-right: 60%;">
                </div>
            @endforeach
        @else
            <h5>No comments...</h5>
        @endif
    </div>
@endsection
