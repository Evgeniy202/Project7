@extends('admin.layouts.base')
@section('title', 'All Categories')
@section('content')
    <h1>Секція</h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Пріорітет</th>
            <th scope="col">Назва</th>
            <th scope="col">Змінити</th>
            <th scope="col">Видалити</th>
        </tr>
        </thead>
        <tbody>
        @foreach($sections as $section)
            <tr>
                <th scope="row">{{ $section->priority }}</th>
                <td>{{ $section->title }}</td>
                <td>
                    <button class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#changeModal-{{ $section->id }}">Змінити
                    </button>
                    <div class="modal fade" id="changeModal-{{ $section->id }}" tabindex="-1"
                         aria-labelledby="changeModalLabel-{{ $section->title }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-dark">
                                    <h5 class="modal-title text-center"
                                        id="changeModalLabel-{{ $section->title }}">
                                        <strong>Змінити назву {{ $section->title }}</strong>
                                    </h5>
                                </div>
                                <div class="modal-body text-dark">
                                    <div>
                                        <form action="{{ route('sections.update', $section) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group mt-3">
                                                <input type="number" name="priority"
                                                       id="priority" placeholder="Пріорітет..."
                                                       class="form-control text-center"
                                                       value="{{ $section->priority }}">
                                            </div>
                                            <div class="form-group mt-3">
                                                <input type="text" name="title"
                                                       id="title" placeholder="Назва..."
                                                       class="form-control text-center"
                                                       value="{{ $section->title }}"
                                                       required>
                                            </div>
                                            <hr>
                                            <input type="submit" class="btn btn-warning btn-block col-12"
                                                   value="Змінити">
                                        </form>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Звернути
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <button class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#removeModal-{{ $section->id }}">Видалити
                    </button>
                    <div class="modal fade" id="removeModal-{{ $section->id }}" tabindex="-1"
                         aria-labelledby="removeModalLabel-{{ $section->title }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-dark">
                                    <h5 class="modal-title text-center"
                                        id="removeModalLabel-{{ $section->title }}">
                                        <strong>Видалити {{ $section->title }}</strong>
                                    </h5>
                                </div>
                                <div class="modal-body text-dark">
                                    <div>
                                        Ви впевнені, що хочете видалити розділ "{{ $section->title }}"?
                                        Усі товари цієї секції також будуть видалені!
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Звернути
                                    </button>
                                    <form action="{{ route('sections.destroy', $section) }}" method="POST">
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
