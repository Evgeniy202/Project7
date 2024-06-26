@extends('layouts.app')
@section('title')
    Category {{ $currentCategory->title }} - Products
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <aside class="col-lg-3">
                <button class="btn btn-outline-secondary mb-3 w-100  d-lg-none" data-bs-toggle="collapse"
                        data-bs-target="#aside_filter">Show filter
                </button>
                <!-- ===== Card for sidebar filter ===== -->
                <div id="aside_filter" class="collapse card d-lg-block mb-5">
                    <form
                        action="{{ isset($sort) ? route('filterCategoryPublic', [$currentCategory->id, $sort]) : route('category.show', $currentCategory) }}"
                        method="GET">
                        <button class="btn btn-outline-success col-md-6 m-1" type="submit">Застосувати</button>
                        <a href="{{ route('category.show', $currentCategory) }}"
                           class="btn btn-outline-warning col-md-4 m-1" type="button">Скинути</a>
                        <article class="filter-group">
                            <header class="card-header">
                                <a href="#" class="title" data-bs-toggle="collapse"
                                   data-bs-target="#collapse_aside2"
                                   aria-expanded="true">
                                    <i class="icon-control fa fa-chevron-down"></i> Ціна
                                </a>
                            </header>
                            <div class="collapse show" id="collapse_aside2" style="">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="range-slider-container">
                                            <input type="range" class="form-range" id="min_price"
                                                   name="min_price"
                                                   value="{{ $activeFeatures['min_price'] ?? $price[0] }}"
                                                   min="{{ $price[0] }}" max="{{ $price[1] }}">
                                            <div class="price-range text-center">
                                                <b><span
                                                        id="min_price_label">{{ $activeFeatures['min_price'] ?? $price[0] }}</span>
                                                    грн -
                                                    <span
                                                        id="max_price_label">{{ $activeFeatures['max_price'] ?? $price[1] }}</span>
                                                    грн</b>
                                            </div>
                                            <input type="range" class="form-range" id="max_price"
                                                   name="max_price"
                                                   value="{{ $activeFeatures['max_price'] ?? $price[1] }}"
                                                   min="{{ $price[0] }}" max="{{ $price[1] }}">
                                        </div>
                                        <script src="/js/products/priceFilter.js"></script>
                                    </div> <!-- row end.// -->
                                </div> <!-- card-body.// -->
                            </div> <!-- collapse.// -->
                        </article> <!-- filter-group // -->
                        @foreach($features as $feature)
                            <article class="filter-group">
                                <header class="card-header">
                                    <a href="#" class="title" data-bs-toggle="collapse"
                                       data-bs-target="#collapse_aside_{{ $feature->id }}">
                                        <i class="icon-control fa fa-chevron-down"></i> {{ $feature->title }}
                                    </a>
                                </header>
                                <div class="collapse show" id="collapse_aside_{{ $feature->id }}">
                                    <div class="card-body">
                                        @foreach($values as $value)
                                            @if($value->char == $feature->id)
                                                <label class="form-check mb-2 text-dark">
                                                    @if($activeFeatures != null)
                                                        @if(in_array($feature->id.'-'.$value->id, $activeFeatures))
                                                            <input id="{{ $feature->id }}-{{ $value->id }}"
                                                                   name="{{ $feature->id }}-{{ $value->id }}"
                                                                   class="form-check-input" type="checkbox"
                                                                   checked>
                                                            <span
                                                                class="form-check-label"> {{ $value->value }} </span>
                                                        @else
                                                            <input id="{{ $feature->id }}-{{ $value->id }}"
                                                                   name="{{ $feature->id }}-{{ $value->id }}"
                                                                   class="form-check-input" type="checkbox"
                                                            >
                                                            <span
                                                                class="form-check-label"> {{ $value->value }} </span>
                                                        @endif
                                                    @else
                                                        <input id="{{ $feature->id }}-{{ $value->id }}"
                                                               name="{{ $feature->id }}-{{ $value->id }}"
                                                               class="form-check-input" type="checkbox"
                                                        >
                                                        <span
                                                            class="form-check-label"> {{ $value->value }} </span>
                                                    @endif
                                                </label> <!-- form-check end.// -->
                                            @endif
                                        @endforeach
                                    </div> <!-- card-body .// -->
                                </div> <!-- collapse.// -->
                            </article>
                        @endforeach
                    </form>
                </div> <!-- card.// -->
                <!-- ===== Card for sidebar filter .// ===== -->
            </aside> <!-- col .// -->
            <main class="col-lg-9">
                <header class="d-sm-flex align-items-center border-bottom mb-4 pb-3">
                    <h1 class="d-block py-2">{{ $currentCategory->title }}</h1>
                    <div class="ms-auto">
                        <label for="sort"><strong>Сортування:</strong></label>
                        <select name="sort" id="sort" class="form-select d-inline-block w-auto">
                            @if(!empty($sort))
                                @if($sort == "cheap")
                                    <option value="{{$currentCategory->id}}-cheap">Спочатку дешевше</option>
                                    <option value="{{$currentCategory->id}}-expensive">Спочатку дорогі</option>
                                    <option value="{{$currentCategory->id}}-normal">Звичайне</option>
                                @elseif($sort == "expensive")
                                    <option value="{{$currentCategory->id}}-expensive">Спочатку дорогі</option>
                                    <option value="{{$currentCategory->id}}-normal">Звичайне</option>
                                    <option value="{{$currentCategory->id}}-cheap">Спочатку дешевше</option>
                                @endif
                            @else
                                <option value="{{$currentCategory->id}}-normal">Звичайне</option>
                                <option value="{{$currentCategory->id}}-cheap">Спочатку дешевше</option>
                                <option value="{{$currentCategory->id}}-expensive">Спочатку дорогі</option>
                            @endif
                        </select>
                        <script
                            src="https://code.jquery.com/jquery-3.6.0.min.js"
                            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
                            crossorigin="anonymous"
                        ></script>
                    </div>
                    <script src="/js/products/sort.js"></script>
                </header>
                @include('layouts.productsCategory')
            </main> <!-- col .// -->
        </div>
    </div>
@endsection
