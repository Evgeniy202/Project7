@extends('admin.layouts.base')
@section('title', 'Проекти - Банери')
@section('content')
    <h1>Банери</h1>
    <hr class="mt-2">
    <button type="button" class="btn btn-outline-success col-md-12" data-bs-toggle="modal"
            data-bs-target="#orderDetails-">
        Додати новий банер
    </button>
    <div class="modal fade" id="orderDetails-" tabindex="-1" aria-labelledby="orderDetailsLabel-"
         aria-hidden="true">
        <div class="modal-dialog modal-x">
            <div class="modal-content text-dark">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="orderDetailsLabel-">
                        Додати новий продукт
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mt-3">
                                <div class="form-group mt-3">
                                    <input type="text" name="title" id="title" placeholder="Назва..."
                                           class="form-control">
                                </div>
                                <div class="form-group mt-3">
                                    <input type="text" name="link" id="link" placeholder="Посилання..."
                                           class="form-control">
                                </div>
                                <div class="form-group mt-3">
                                    <input type="number" name="priority" id="priority" placeholder="Пріоритет..."
                                           class="form-control">
                                </div>
                                <div class="form-group mt-3">
                                    <label>Активний <input type="checkbox" name="active" id="active"
                                                           value="1"></label>
                                </div>
                                <div class="form-group mt-3">
                                    <label>Зображення <input type="file" name="image" id="image"></label>
                                </div>
                                <div class="form-group mt-3">
                                    <textarea class="form-control" name="description" id="description" rows="10"
                                              placeholder="Опис..."></textarea>
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
    <hr class="mt-2">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Пріоритет</th>
            <th scope="col">Зображення</th>
            <th scope="col">Назва</th>
            <th scope="col">Посилання</th>
            <th scope="col">Активний</th>
            <th scope="col">Дії</th>
        </tr>
        </thead>
        <tbody>
        @foreach($banners as $banner)
            <tr>
                <th scope="row">{{ $banner->priority }}</th>
                <th scope="row">
                    <button class="btn btn-outline-" type="button" data-bs-toggle="modal"
                            data-bs-target="#imageDetails-{{ $banner->id }}">
                        <img src="{{ asset('/storage/'.$banner->image) }}"
                             alt="{{ $banner->title }}_{{ $banner->position }}"
                             height="50px">
                    </button>
                    <div class="modal fade" id="imageDetails-{{ $banner->id }}" tabindex="-1"
                         aria-labelledby="imageDetailsLabel-{{ $banner->id }}"
                         aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content text-dark">
                                <div class="modal-header bg-dark">
                                    <h5 class="modal-title text-light text-center" id="imageDetails-{{ $banner->id }}">
                                        Банер: {{ $banner->title }}_{{ $banner->position }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body bg-dark">
                                    <div class="row text-light">
                                        <img src="{{ asset('/storage/'.$banner->image) }}"
                                             alt="{{ $banner->title }}_{{ $banner->position }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </th>
                <td>{{ $banner->title }}</td>
                <td>
                    @if(!empty($banner->link))
                        {{ $banner->link }}
                    @else
                        Порожнє
                    @endif
                </td>
                <td><strong>
                        @if($banner->active == 1)
                            +
                        @else
                            -
                        @endif
                    </strong>
                </td>
                <td>
                    <button class="btn btn-warning col-5" data-bs-toggle="modal"
                            data-bs-target="#changeModal-{{ $banner->id }}">Деталі або Змінити банер
                    </button>
                    <div class="modal fade" id="changeModal-{{ $banner->id }}" tabindex="-1"
                         aria-labelledby="changeModalLabel-{{ $banner->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-x">
                            <div class="modal-content">
                                <div class="modal-header text-dark">
                                    <h5 class="modal-title text-center" id="changeModalLabel-{{ $banner->id }}">
                                        <strong>Банер - {{ $banner->title }}</strong>
                                    </h5>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <form action="{{ route('banner.update', $banner) }}" method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group mt-3">
                                                <input type="text" name="title" id="title" placeholder="Заголовок..."
                                                       class="form-control" value="{{ $banner->title }}">
                                            </div>
                                            <div class="form-group mt-3">
                                                <input type="text" name="link" id="link" placeholder="Посилання..."
                                                       class="form-control" value="{{ $banner->link }}">
                                            </div>
                                            <div class="form-group mt-3">
                                                <input type="number" name="priority" id="priority"
                                                       placeholder="Пріоритет..." class="form-control"
                                                       value="{{ $banner->priority }}">
                                            </div>
                                            <div class="form-group mt-3">
                                                @if($banner->active == 1)
                                                    <label>Активний <input type="checkbox" name="active" id="active"
                                                                           value="1" checked></label>
                                                @else
                                                    <label>Активний <input type="checkbox" name="active" id="active"
                                                                           value="1"></label>
                                                @endif
                                            </div>
                                            <div class="form-group mt-3">
                                                <label>Зображення <input type="file" name="image" id="image"></label>
                                            </div>
                                            <div class="form-group mt-3">
                                                <textarea class="form-control" name="description" id="description"
                                                          rows="10"
                                                          placeholder="Опис...">{{ $banner->description }}</textarea>
                                            </div>
                                            <hr>
                                            <input type="submit" class="btn btn-warning btn-block col-12"
                                                   value="Змінити">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-danger col-5" data-bs-toggle="modal"
                            data-bs-target="#removeModal-{{ $banner->id }}">Видалити банер
                    </button>
                    <div class="modal fade" id="removeModal-{{ $banner->id }}" tabindex="-1"
                         aria-labelledby="removeModalLabel-{{ $banner->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-dark">
                                    <h5 class="modal-title text-center" id="removeModalLabel-{{ $banner->id }}">
                                        <strong>Видалити банер</strong>
                                    </h5>
                                </div>
                                <div class="modal-body text-dark">
                                    <div>Ви впевнені, що хочете видалити цей банер?</div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Закрити
                                    </button>
                                    <form action="{{ route('banner.destroy', $banner) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger">Видалити</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
