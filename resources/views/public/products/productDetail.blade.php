@extends('layouts.app')
@section('title')
    Project7 - {{ $product->title }}
@endsection
@section('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"/>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
@endsection
@section('content')
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
                <p>Price: {{ $product->price }} грн.</p>
                <p>Description: {{ $product->description }} </p>
                <hr>
                @if(!empty(Auth::user()->id))
                    <a href="#" class="btn btn-outline-primary">Add to selected</a>
                    <a href="#" class="btn btn-outline-success">Add to cart</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">Add to selected</a>
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
                    <form action="#" method="POST" class="p-5">
                        @csrf
                        <input type="text" id="name" name="name" class="form-control m-2" placeholder="You name">
                        <textarea id="comment" name="comment" class="form-control m-2" rows="5"
                                  placeholder="You comment"></textarea>
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
