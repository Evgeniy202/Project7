@extends('layouts.app')
@section('title', 'Project7')
@section('content')
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($banners as $banner)
                @if($banner == $banners->first())
                    @if(empty($banner->link))
                        <div class="carousel-item active">
                            <img src="{{ asset('/storage/' . $banner->image) }}" class="d-block w-100"
                                 alt="{{ $banner->title }}">
                        </div>
                    @else
                        <div class="carousel-item active">
                            <a href="{{ $banner->link }}">
                                <img src="{{ asset('/storage/' . $banner->image) }}" class="d-block w-100"
                                     alt="{{ $banner->title }}">
                            </a>
                        </div>
                    @endif
                @else
                    @if(empty($banner->link))
                        <div class="carousel-item">
                            <img src="{{ asset('/storage/' . $banner->image) }}" class="d-block w-100"
                                 alt="{{ $banner->title }}">
                        </div>
                    @else
                        <div class="carousel-item">
                            <a href="{{ $banner->link }}">
                                <img src="{{ asset('/storage/' . $banner->image) }}" class="d-block w-100"
                                     alt="{{ $banner->title }}">
                            </a>
                        </div>
                    @endif
                @endif
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <hr>
    <main class="container bg-dark text-light rounded-2">
        <header class="section-heading">
            <h1 class="section-title">Recommended Products</h1>
        </header>
        <script
            src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"
        ></script>
        @include('layouts.products')
    </main>
@endsection
