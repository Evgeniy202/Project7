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
                             class="img-fluid w-100 rounded">Більше зображень</a>
                </div>
            </div>
            <div class="col-md-8">
                <h3> {{ $product->title }} </h3>
                <p>Price: @if (!empty($discount))
                        <strong class="price text-danger">${{ $product->price - $discount }} зі зінишкою!</strong>
                        <br>
                        <del class="price-old"> ${{ $product->price }}</del>
                    @else
                        <strong class="price"> ${{ $product->price }} </strong>
                    @endif
                </p>
                @if ($rating)
                    <p>Рейтинг: {{ $rating }}/10</p>
                @endif
                <p>Опис: {{ $product->description }} </p>
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
                        Додати до обраних
                    </button>
                    <a href="{{ route('add-to-cart', $product->id) }}" class="btn btn-outline-success">Додати в кошик</a>
                    <button type="button" class="btn btn-outline-warning"
                            data-bs-toggle="modal"
                            data-bs-target="#modalWindow">Оцінити
                    </button>
                    <div class="modal fade" id="modalWindow" tabindex="-1"
                         aria-labelledby="modalWindowLabel"
                         aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content text-dark">
                                <div class="modal-header">
                                    <h5 class="modal-title text-center"
                                        id="modalWindowLabel">
                                        Обрати оцінку
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="{{ route('add-rating', $product->id) }}">
                                        @csrf
                                        <div class="d-flex justify-content-between">
                                            <span>0</span>
                                            <span>1</span>
                                            <span>2</span>
                                            <span>3</span>
                                            <span>4</span>
                                            <span>5</span>
                                            <span>6</span>
                                            <span>7</span>
                                            <span>8</span>
                                            <span>9</span>
                                            <span>10</span>
                                        </div>
                                        <input class="col-12" type="range" id="rating" name="rating" min="0" max="10">
                                        <hr>
                                        <input type="submit" class="btn btn-success col-12" value="Send">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-danger">Додати до обраних</a>
                    <a href="{{ route('login') }}" class="btn btn-outline-success">Додати до кошика</a>
                    <a href="{{ route('login') }}" class="btn btn-outline-warning">Оцінити</a>
                @endif
            </div>
            <hr>
            <h4>Характеристики:</h4>
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
        <h3 class="mb-2">Коментарі:</h3>
        @if (!empty(Auth::user()->id))
            <div class="text-light">
                <div class="col-md-12">
                    <h3 class=""></h3>
                    <form action="{{ route('add-comment', $product->id) }}" method="POST" class="p-5">
                        @csrf
                        <input type="text" id="name" name="name" class="form-control m-2" placeholder="Ваше ім'я"
                               required>
                        <textarea id="comment" name="comment" class="form-control m-2" rows="5"
                                  placeholder="Ваш коментар" required></textarea>
                        <input type="submit" class="btn btn-outline-success m-2 col-12" value="Додати коментар">
                    </form>
                </div>
            </div>
            <hr>
        @endif
        @if(!empty($comments->first()))
            @foreach($comments as $comment)
                <div class="comment card mt-4">
                    <div class="card-body">
                        <h6 class="card-title">{{ $comment->name }} @if($isAdmin) (ID користувача: {{$comment->user}}) @endif <span class="text-muted">- {{ $comment->created_at->format('Y-m-d H:i:s') }}</span></h6>
                        <p class="card-text">{{ $comment->comment }}</p>
                        <!-- Додамо кнопку видалити лише для адміністраторів -->
                        @if($isAdmin)
                            <form action="{{ route('remove-comment', $comment->id) }}" method="GET">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Видалити</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <h5>Немає коментарів...</h5>
        @endif
    </div>
@endsection

