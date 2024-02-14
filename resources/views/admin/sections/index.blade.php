@extends('admin.layouts.base')
@section('title', 'All Categories')
@section('content')
    <h1>Sections</h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Priority</th>
            <th scope="col">Title</th>
            <th scope="col">Change</th>
            <th scope="col">Remove</th>
        </tr>
        </thead>
        <tbody>
        @foreach($sections as $section)
            <tr>
                <th scope="row">{{ $section->priority }}</th>
                <td>{{ $section->title }}</td>
                <td>
                    <button class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#changeModal-{{ $section->id }}">Change
                    </button>
                    <div class="modal fade" id="changeModal-{{ $section->id }}" tabindex="-1"
                         aria-labelledby="changeModalLabel-{{ $section->title }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-dark">
                                    <h5 class="modal-title text-center"
                                        id="changeModalLabel-{{ $section->title }}">
                                        <strong>Change tittle {{ $section->title }}</strong>
                                    </h5>
                                </div>
                                <div class="modal-body text-dark">
                                    <div>
                                        <form action="{{ route('sections.update', $section) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group mt-3">
                                                <input type="number" name="priority"
                                                       id="title" placeholder="Priority..."
                                                       class="form-control text-center"
                                                       value="{{ $section->priority }}">
                                            </div>
                                            <div class="form-group mt-3">
                                                <input type="text" name="title"
                                                       id="title" placeholder="Title..."
                                                       class="form-control text-center"
                                                       value="{{ $section->title }}"
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
                            data-bs-target="#removeModal-{{ $section->id }}">Remove
                    </button>
                    <div class="modal fade" id="removeModal-{{ $section->id }}" tabindex="-1"
                         aria-labelledby="removeModalLabel-{{ $section->title }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-dark">
                                    <h5 class="modal-title text-center"
                                        id="removeModalLabel-{{ $section->title }}">
                                        <strong>Remove {{ $section->title }}</strong>
                                    </h5>
                                </div>
                                <div class="modal-body text-dark">
                                    <div>
                                        You are sure you want to delete the section "{{ $section->title }}"?
                                        All products in this category will also be removed!
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <form action="{{ route('sections.destroy', $section) }}" method="POST">
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
