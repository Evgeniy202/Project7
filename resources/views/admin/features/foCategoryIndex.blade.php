@extends('admin.layouts.base')
@section('title')
    Features of {{ $category->title }}
@endsection
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Features of {{ $category->title }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <hr>
    <div>
        <button type="button" class="btn btn-outline-success col-12" data-bs-toggle="modal"
                data-bs-target="#newFeaturesModal">
            Add new feature
        </button>
        <div class="modal fade" id="newFeaturesModal" tabindex="-1" aria-labelledby="newFeaturesLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-l">
                <div class="modal-content text-dark">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="newFeaturesLabel">
                            Add new Characteristic
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form action="{{ route('newFeaturesOfCategory', $category->id) }}" method="POST">
                                @csrf
                                <div class="form-group mt-3">
                                    <input type="text" name="title" id="title"
                                           placeholder="Title..." class="form-control text-center" required>
                                </div>
                                <div class="form-group mt-3">
                                    <input type="number" name="numberInFilter"
                                           id="numberInFilter" placeholder="Number in filter..."
                                           class="form-control text-center">
                                </div>
                                <hr>
                                <input type="submit" class="btn btn-success btn-block col-12" value="Add">
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
                <th scope="col">Number in filter</th>
                <th scope="col">Tittle</th>
                <th scope="col">Values</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($features as $feature)
                <tr>
                    <th scope="row">{{ $feature->numberInFilter }}</th>
                    <td>{{ $feature->title }}</td>
                    <td>
                        <button class="btn btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#valuesModal-{{ $feature->id }}">Values
                        </button>
                        <div class="modal fade" id="valuesModal-{{ $feature->id }}" tabindex="-1"
                             aria-labelledby="valuesModalLabel-{{ $feature->title }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header text-dark">
                                        <h5 class="modal-title text-center"
                                            id="valuesModalLabel-{{ $feature->title }}">
                                            <strong>Values of {{ $feature->title }}</strong>
                                        </h5>
                                    </div>
                                    <div class="modal-body text-dark">
                                        <a class="btn btn-outline-secondary col-12"
                                           href="#">
                                            Manage characteristic
                                        </a>
                                        <hr>
                                        <div class="text-center">
                                            @foreach ($values as $value)
                                                @if ($value->char == $feature->id)
                                                    <strong> |{{ $value->value }}| </strong>
                                                @endif
                                            @endforeach
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
                        <button class=" col-5 btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#changeModal-{{ $feature->id }}">Change
                        </button>
                        <div class="modal fade" id="changeModal-{{ $feature->id }}" tabindex="-1"
                             aria-labelledby="changeModalLabel-{{ $feature->title }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header text-dark">
                                        <h5 class="modal-title text-center"
                                            id="changeModalLabel-{{ $feature->title }}">
                                            <strong>Change tittle {{ $feature->title }}</strong>
                                        </h5>
                                    </div>
                                    <div class="modal-body text-dark">
                                        <div>
                                            <form
                                                action="{{ route('updateOfCategory', ['category' => $category->id, 'featureId' => $feature->id]) }}"
                                                method="POST">
                                                @csrf
                                                <input type="text" name="category" id="category"
                                                       value="{{ $category->id }}" hidden readonly required>
                                                <div class="form-group mt-3">
                                                    <input type="number" name="numberInFilter" id="numberInFilter"
                                                           placeholder="Number In Filter..."
                                                           class="form-control text-center"
                                                           value="{{ $feature->numberInFilter }}">
                                                </div>
                                                <div class="form-group mt-3">
                                                    <input type="text" name="title" id="title"
                                                           placeholder="Title..." class="form-control text-center"
                                                           value="{{ $feature->title }}">
                                                </div>
                                                <hr>
                                                <input type="submit" class="btn btn-success btn-block col-12"
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
                        <button class="col-5 btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#removeModal-{{ $feature->id }}">Remove
                        </button>
                        <div class="modal fade" id="removeModal-{{ $feature->id }}" tabindex="-1"
                             aria-labelledby="removeModalLabel-{{ $feature->title }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header text-dark">
                                        <h5 class="modal-title text-center"
                                            id="removeModalLabel-{{ $feature->title }}">
                                            <strong>Remove {{ $feature->title }}</strong>
                                        </h5>
                                    </div>
                                    <div class="modal-body text-dark">
                                        <div>
                                            You are sure you want to delete the characteristic "{{ $feature->title }}"?
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <form action="{{ route('deleteOfCategory', ['category' => $category->id, 'featureId' => $feature->id]) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-outline-danger">
                                                Remove
                                            </button>
                                        </form>
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
