@extends('admin.layouts.base')
@section('title')
    Значення {{ $feature->title }}
@endsection
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Значення {{ $feature->title }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <hr>
    <div>
        <button type="button" class="btn btn-outline-success col-12" data-bs-toggle="modal"
                data-bs-target="#newFeaturesModal">
            Додати нове значення
        </button>
        <div class="modal fade" id="newFeaturesModal" tabindex="-1" aria-labelledby="newFeaturesLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-l">
                <div class="modal-content text-dark">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="newFeaturesLabel">
                            Додати нове значення
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form action="{{ route('createValuesOfFeature', [$category, $feature->id]) }}"
                                method="POST">
                                @csrf
                                <div class="form-group mt-3">
                                    <input type="text" name="title" id="title"
                                        placeholder="Значення..." class="form-control text-center" required>
                                </div>
                                <div class="form-group mt-3">
                                    <input type="number" name="numberInFilter"
                                        id="numberInFilter" placeholder="Номер в фільтрі..."
                                        class="form-control text-center">
                                </div>
                                <hr>
                                <input type="submit" class="btn btn-success btn-block col-12" value="Додати">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Номер в фільтрі</th>
                <th scope="col">Значення</th>
                <th scope="col">Дії</th>
            </tr>
            </thead>
            <tbody>
            @foreach($values as $value)
                <tr>
                    <th scope="row">{{ $value->numberInFilter }}</th>
                    <td>{{ $value->value }}</td>
                    <td>
                        <button class=" col-5 btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#changeModal-{{ $value->id }}">Змінити
                        </button>
                        <div class="modal fade" id="changeModal-{{ $value->id }}" tabindex="-1"
                            aria-labelledby="changeModalLabel-{{ $value->value }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header text-dark">
                                        <h5 class="modal-title text-center"
                                            id="changeModalLabel-{{ $value->value }}">
                                            <strong>Змінити назву {{ $value->value }}</strong>
                                        </h5>
                                    </div>
                                    <div class="modal-body text-dark">
                                        <div>
                                            <form
                                                action="{{ route('updateValuesOfFeature', [$category, $feature->id, $value->id]) }}"
                                                method="POST">
                                                @csrf
                                                <div class="form-group mt-3">
                                                    <input type="number" name="numberInFilter" id="numberInFilter"
                                                        placeholder="Номер в фільтрі..."
                                                        class="form-control text-center"
                                                        value="{{ $value->numberInFilter }}">
                                                </div>
                                                <div class="form-group mt-3">
                                                    <input type="text" name="title" id="title"
                                                        placeholder="Назва..." class="form-control text-center"
                                                        value="{{ $value->value }}">
                                                </div>
                                                <hr>
                                                <input type="submit" class="btn btn-success btn-block col-12"
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
                        <button class="col-5 btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#removeModal-{{ $value->id }}">Видалити
                        </button>
                        <div class="modal fade" id="removeModal-{{ $value->id }}" tabindex="-1"
                            aria-labelledby="removeModalLabel-{{ $value->value }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header text-dark">
                                        <h5 class="modal-title text-center"
                                            id="removeModalLabel-{{ $value->value }}">
                                            <strong>Видалити {{ $value->value }}</strong>
                                        </h5>
                                    </div>
                                    <div class="modal-body text-dark">
                                        <div>
                                            Ви впевнені, що хочете видалити значення "{{ $value->value }}"?
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                            Закрити
                                        </button>
                                        <a href="{{ route('removeValuesOfFeature', [$category, $feature->id, $value->id]) }}"
                                        class="btn btn-outline-danger">
                                            Видалити
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
