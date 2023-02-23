@extends('admin.layouts.base')
@section('title', 'All Categories')
@section('content')
    <h1>Categories</h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Priority</th>
            <th scope="col">Tittle</th>
            <th scope="col">Features</th>
            <th scope="col">Change</th>
            <th scope="col">Remove</th>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
                <th scope="row">{{ $category->priority }}</th>
                <td>{{ $category->title }}</td>
                <td>
                    <button class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#charModal-{{ $category->id }}">Features
                    </button>
                    <div class="modal fade" id="charModal-{{ $category->id }}" tabindex="-1"
                         aria-labelledby="charModalLabel-{{ $category->title }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-dark">
                                    <h5 class="modal-title text-center" id="charModalLabel-{{ $category->title }}">
                                        <strong>Characteristics of {{ $category->title }}</strong>
                                    </h5>
                                </div>
                                <div class="modal-body text-dark">
                                    <div>
                                        <a class="col-12 btn btn-outline-secondary"
                                           href="{{ route('featuresOfCategory', $category->id) }}">
                                            Manage characteristic
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
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <button class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#changeModal-{{ $category->id }}">Change
                    </button>
                    <div class="modal fade" id="changeModal-{{ $category->id }}" tabindex="-1"
                         aria-labelledby="changeModalLabel-{{ $category->title }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-dark">
                                    <h5 class="modal-title text-center"
                                        id="changeModalLabel-{{ $category->title }}">
                                        <strong>Change tittle {{ $category->title }}</strong>
                                    </h5>
                                </div>
                                <div class="modal-body text-dark">
                                    <div>
                                        <form action="{{ route('categories.update', $category) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group mt-3">
                                                <input type="number" name="priority"
                                                       id="title" placeholder="Priority..."
                                                       class="form-control text-center"
                                                       value="{{ $category->priority }}">
                                            </div>
                                            <div class="form-group mt-3">
                                                <input type="text" name="title"
                                                       id="title" placeholder="Title..."
                                                       class="form-control text-center"
                                                       value="{{ $category->title }}"
                                                       required>
                                            </div>
                                            <hr>
                                            <input type="submit" class="btn btn-warning btn-block col-12"
                                                   value="Change">
                                        </form>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <button class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#removeModal-{{ $category->id }}">Remove
                    </button>
                    <div class="modal fade" id="removeModal-{{ $category->id }}" tabindex="-1"
                         aria-labelledby="removeModalLabel-{{ $category->title }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-dark">
                                    <h5 class="modal-title text-center"
                                        id="removeModalLabel-{{ $category->title }}">
                                        <strong>Remove {{ $category->title }}</strong>
                                    </h5>
                                </div>
                                <div class="modal-body text-dark">
                                    <div>
                                        You are sure you want to delete the category "{{ $category->title }}"?
                                        All products in this category will also be removed!
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">Remove</button>
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
