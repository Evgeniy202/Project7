@extends('admin.layouts.base')
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
                        <select name="meth" id="meth" class="form-select d-inline-block w-auto">
{{--                            @foreach($sortList as $sort)--}}
                                <option value="0">#</option>
{{--                            @endforeach--}}
                        </select>
                    </div>
                    {{--                    <script>--}}
                    {{--                        $(document).ready(function () {--}}
                    {{--                            $('#meth').on('change', function () {--}}
                    {{--                                var sort = $(this).val();--}}
                    {{--                                if (sort) {--}}
                    {{--                                    window.location.replace("/category/{{ $category->id }}?sort=" + sort);--}}
                    {{--                                }--}}
                    {{--                            });--}}
                    {{--                        });--}}
                    {{--                    </script>--}}
                </header>
                <!-- ========= content items ========= -->
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-lg-3 col-md-5 col-sm-5 bg-gradient m-4">
                            <figure class="card-product-grid">
                                <div class="bg-light rounded mt-2">
                                    <a href="#"
                                       class="img-wrap rounded bg-gray-light">
                                        <img height="100" class="mix-blend-multiply mt-4 m-5 rounded"
                                             src="{{ asset('/storage/'.$images[$product->id]) }}"
                                             alt="{{ $product->title }}">
                                    </a>
                                </div>
                                <figcaption class="pt-2">
                                    @if (!empty(Auth::user()->id))
                                        <a id="selectBtn-{{ $product->id }}"
                                           href="#"
                                           class="float-end btn btn-light btn-outline-danger"><i
                                                class="bi bi-heart">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                                     fill="currentColor" class="bi bi-heart"
                                                     viewBox="0 0 16 16">
                                                    <path
                                                        d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                                                </svg>
                                            </i></a>
                                    @else
                                        <a id="selectBtn-{{ $product->id }}"
                                           href="{{ route('login') }}"
                                           class="float-end btn btn-light btn-outline-danger"><i
                                                class="bi bi-heart">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                                     fill="currentColor" class="bi bi-heart"
                                                     viewBox="0 0 16 16">
                                                    <path
                                                        d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                                                </svg>
                                            </i></a>
                                    @endif
                                    <b>
                                        <a href="#"
                                           class="title text-danger">{{ $product->title }}</a>
                                    </b>
                                    <br>
                                    <small class="text-muted">{{ $currentCategory->title }}</small>
                                    <br>
                                    <strong class="price">{{ $product->price }} $</strong> <!-- price.// -->
                                </figcaption>
                            </figure>
                        </div> <!-- col end.// -->
                    @endforeach
                </div> <!-- row end.// -->
                <hr>
                <footer class="d-flex mt-4">
                    {{ $products->links() }}
                </footer>
            {{--                <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>--}}
            <!-- ========= content items .// ========= -->
            </main> <!-- col .// -->
        </div>
    </div>
@endsection
