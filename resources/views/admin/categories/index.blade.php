@extends('admin.layouts.base')
@section('title', 'Усі категорії')
@section('content')
    <h1>Категорії</h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Пріоритет</th>
            <th scope="col">Назва</th>
            <th scope="col">Розділ</th>
            <th scope="col">Характеристики</th>
            <th scope="col">Змінити</th>
            <th scope="col">Видалити</th>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
                <th scope="row">{{ $category->priority }}</th>
                <td>{{ $category->title }}</td>
                <td>
                    @if(!$category->section == null)
                        {{ $category->section_title }}
                    @else
                        Немає
                    @endif
                </td>
                <td>
                    <button class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#charModal-{{ $category->id }}">Характеристики
                    </button>
                    <div class="modal fade" id="charModal-{{ $category->id }}" tabindex="-1"
                         aria-labelledby="charModalLabel-{{ $category->title }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-dark">
                                    <h5 class="modal-title text-center" id="charModalLabel-{{ $category->title }}">
                                        <strong>Характеристики {{ $category->title }}</strong>
                                    </h5>
                                </div>
                                <div class="modal-body text-dark">
                                    <div>
                                        <a class="col-12 btn btn-outline-secondary"
                                           href="{{ route('featuresOfCategory', $category->id) }}">
                                            Управління характеристиками
                                        </a>
                                        <hr>
                                        <div class="text-center">
                                            @foreach ($charList as $char)
                                                @if ($char->category == $category->id)
                                                    <strong> |{{ $char->title }}| </strong>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Закрити
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <button class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#changeModal-{{ $category->id }}">Змінити
                    </button>
                    <div class="modal fade" id="changeModal-{{ $category->id }}" tabindex="-1"
                         aria-labelledby="changeModalLabel-{{ $category->title }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-dark">
                                    <h5 class="modal-title text-center"
                                        id="changeModalLabel-{{ $category->title }}">
                                        <strong>Змінити назву "{{ $category->title }}"</strong>
                                    </h5>
                                </div>
                                <div class="modal-body text-dark">
                                    <div>
                                        <form action="{{ route('categories.update', $category) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group mt-3">
                                                <input type="number" name="priority"
                                                       id="title" placeholder="Пріоритет..."
                                                       class="form-control text-center"
                                                       value="{{ $category->priority }}">
                                            </div>
                                            <div class="form-group mt-3">
                                                <input type="text" name="title"
                                                       id="title" placeholder="Назва..."
                                                       class="form-control text-center"
                                                       value="{{ $category->title }}"
                                                       required>
                                            </div>
                                            <div class="form-group mt-3">
                                                <select class="form-control text-center btn-outline-secondary"
                                                        name="section">
                                                    @if($category->section != null)
                                                        <option value="{{ $category->section }}">
                                                            {{ $category->section_title }}
                                                        </option>
                                                        @foreach ($sections as $section)
                                                            @if($section->id != $category->section)
                                                                <option
                                                                    value="{{ $section->id }}">{{ $section->title }}</option>
                                                            @endif
                                                        @endforeach
                                                        <option value="null">Немає</option>
                                                    @else
                                                        <option value="null">Немає</option>
                                                        @foreach ($sections as $section)
                                                            <option
                                                                value="{{ $section->id }}">{{ $section->title }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <hr>
                                            <input type="submit" class="btn btn-warning btn-block col-12"
                                                   value="Змінити">
                                        </form>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Закрити
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <button class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#removeModal-{{ $category->id }}">Видалити
                    </button>
                    <div class="modal fade" id="removeModal-{{ $category->id }}" tabindex="-1"
                         aria-labelledby="removeModalLabel-{{ $category->title }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-dark">
                                    <h5 class="modal-title text-center"
                                        id="removeModalLabel-{{ $category->title }}">
                                        <strong>Видалити "{{ $category->title }}"</strong>
                                    </h5>
                                </div>
                                <div class="modal-body text-dark">
                                    <div>
                                        Ви впевнені, що хочете видалити категорію "{{ $category->title }}"?
                                        Усі товари в цій категорії також будуть видалені!
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Закрити
                                    </button>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">Видалити</button>
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
