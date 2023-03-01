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
                    <form action="#">
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
                                                    {{--                                                    @if(array_key_exists($feature->id.'-'.$value->id, $activeChars))--}}
                                                    <input id="{{ $feature->id }}-{{ $value->id }}"
                                                           name="{{ $feature->id }}-{{ $value->id }}"
                                                           class="form-check-input" type="checkbox"
                                                           value="{{ $feature->id }}-{{ $value->id }}" checked>
                                                    <span class="form-check-label"> {{ $value->value }} </span>
                                                    {{--                                                    @else--}}
                                                    {{--                                                        <input id="{{ $feature->id }}-{{ $value->id }}"--}}
                                                    {{--                                                               name="{{ $feature->id }}-{{ $value->id }}"--}}
                                                    {{--                                                               class="form-check-input" type="checkbox"--}}
                                                    {{--                                                               value="{{ $feature->id }}-{{ $value->id }}">--}}
                                                    {{--                                                        <span class="form-check-label"> {{ $value->value }} </span>--}}
                                                    {{--                                                    @endif--}}
                                                </label> <!-- form-check end.// -->
                                            @endif
                                        @endforeach
                                    </div> <!-- card-body .// -->
                                </div> <!-- collapse.// -->
                            </article>
                        @endforeach
                        <article class="filter-group">
                            <header class="card-header">
                                <a href="#" class="title" data-bs-toggle="collapse" data-bs-target="#collapse_aside2"
                                   aria-expanded="true">
                                    <i class="icon-control fa fa-chevron-down"></i> Price
                                </a>
                            </header>
                            <div class="collapse show" id="collapse_aside2" style="">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label for="min" class="form-label">Min</label>
                                            {{--                                            @if(array_key_exists('min', $activeChars))--}}
                                            <input class="form-control" name="min" id="min" placeholder="$0"
                                                   type="number" value="0">
                                            {{--                                            @else--}}
                                            {{--                                                <input class="form-control" name="min" id="min" placeholder="$0"--}}
                                            {{--                                                       type="number" value="0">--}}
                                            {{--                                            @endif--}}
                                        </div> <!-- col end.// -->
                                        <div class="col-6">
                                            <label for="max" class="form-label">Max</label>
                                            {{--                                            @if(array_key_exists('max', $activeChars))--}}
                                            <input class="form-control" name="max" id="max" placeholder="$1,0000"
                                                   type="number" value="0">
                                            {{--                                            @else--}}
                                            {{--                                                <input class="form-control" name="max" id="max" placeholder="$1,0000"--}}
                                            {{--                                                       type="number" value="0">--}}
                                            {{--                                            @endif--}}
                                        </div> <!-- col end.// -->
                                    </div> <!-- row end.// -->
                                </div> <!-- card-body.// -->
                            </div> <!-- collapse.// -->
                        </article> <!-- filter-group // -->
                        <button class="btn btn-outline-success col-md-6 m-1" type="submit">Apply</button>
                        <a href="{{ route('category.show', $currentCategory) }}"
                           class="btn btn-outline-warning col-md-4 m-1" type="button">Reset</a>
                    </form>
                </div> <!-- card.// -->
                <!-- ===== Card for sidebar filter .// ===== -->
            </aside> <!-- col .// -->
            <main class="col-lg-9">
                <header class="d-sm-flex align-items-center border-bottom mb-4 pb-3">
                    <h1 class="d-block py-2">{{ $currentCategory->title }}</h1>
                    <div class="ms-auto">
                        <label for="sort"><strong>Sort by:</strong></label>
                        <select name="sort" id="sort" class="form-select d-inline-block w-auto">
                            @if(empty($sort))
                                <option value="{{$currentCategory->id}}-random">Randomly</option>
                                <option value="{{$currentCategory->id}}-cheap">Cheap at first</option>
                                <option value="{{$currentCategory->id}}-expensive">First expensive</option>
                            @elseif($sort == "cheap")
                                <option value="{{$currentCategory->id}}-cheap">Cheap at first</option>
                                <option value="{{$currentCategory->id}}-expensive">First expensive</option>
                                <option value="{{$currentCategory->id}}-random">Randomly</option>
                            @elseif($sort == "expensive")
                                <option value="{{$currentCategory->id}}-expensive">First expensive</option>
                                <option value="{{$currentCategory->id}}-random">Randomly</option>
                                <option value="{{$currentCategory->id}}-cheap">Cheap at first</option>
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
                <!-- ========= content items ========= -->
            @include('layouts.productsCategory')

            {{--                <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>--}}
            <!-- ========= content items .// ========= -->
            </main> <!-- col .// -->
        </div>
    </div>
@endsection
