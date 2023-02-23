@extends('admin.layouts.base')
@section('title', 'Banners')
@section('content')
    <h1>Banners</h1>
    <hr class="mt-2">
    <button type="button" class="btn btn-outline-success col-md-12" data-bs-toggle="modal"
            data-bs-target="#orderDetails-">
        Add New Banner
    </button>
    <div class="modal fade" id="orderDetails-" tabindex="-1" aria-labelledby="orderDetailsLabel-"
         aria-hidden="true">
        <div class="modal-dialog modal-x">
            <div class="modal-content text-dark">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="orderDetailsLabel-">
                        Add new product
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mt-3">
                                <div class="form-group mt-3">
                                    <input type="text" name="title" id="title" placeholder="Title..."
                                           class="form-control">
                                </div>
                                <div class="form-group mt-3">
                                    <input type="text" name="link" id="link" placeholder="Link..."
                                           class="form-control">
                                </div>
                                <div class="form-group mt-3">
                                    <input type="number" name="priority" id="priority" placeholder="Priority..."
                                           class="form-control">
                                </div>
                                <div class="form-group mt-3">
                                    <label>Is Active <input type="checkbox" name="active" id="active"
                                                            value="1"></label>
                                </div>
                                <div class="form-group mt-3">
                                    <label>Image <input type="file" name="image" id="image"></label>
                                </div>
                                <div class="form-group mt-3">
                                    <textarea class="form-control" name="description" id="description" rows="10"
                                              placeholder="Description..."></textarea>
                                </div>
                            </div>
                            <hr>
                            <input type="submit" class="btn btn-success btn-block col-12" value="Add">
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
            <th scope="col">Priority</th>
            <th scope="col">Image</th>
            <th scope="col">Title</th>
            <th scope="col">Link</th>
            <th scope="col">Is Active</th>
            <th scope="col">Actions</th>
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
                                        Banner: {{ $banner->title }}_{{ $banner->position }}
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
                        Empty
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
                            data-bs-target="#changeModal-{{ $banner->id }}">Detail Or Change Banner
                    </button>
                    <div class="modal fade" id="changeModal-{{ $banner->id }}" tabindex="-1"
                         aria-labelledby="changeModalLabel-{{ $banner->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-x">
                            <div class="modal-content">
                                <div class="modal-header text-dark">
                                    <h5 class="modal-title text-center"
                                        id="changeModalLabel-{{ $banner->id }}">
                                        <strong>Banner - {{ $banner->title }}</strong>
                                    </h5>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <form action="{{ route('banner.update', $banner) }}" method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group mt-3">
                                                <div class="form-group mt-3">
                                                    <input type="text" name="title" id="title" placeholder="Title..."
                                                           class="form-control" value="{{ $banner->title }}">
                                                </div>
                                                <div class="form-group mt-3">
                                                    <input type="text" name="link" id="link" placeholder="Link..."
                                                           class="form-control" value="{{ $banner->link }}">
                                                </div>
                                                <div class="form-group mt-3">
                                                    <input type="number" name="priority" id="priority"
                                                           placeholder="Priority..."
                                                           class="form-control" value="{{ $banner->priority }}">
                                                </div>
                                                <div class="form-group mt-3">
                                                    @if($banner->active == 1)
                                                        <label>Is Active <input type="checkbox" name="active"
                                                                                id="active"
                                                                                value="1"
                                                                                checked></label>
                                                    @else
                                                        <label>Is Active <input type="checkbox" name="active"
                                                                                id="active"
                                                                                value="1"></label>
                                                    @endif
                                                </div>
                                                <div class="form-group mt-3">
                                                    <label>Image <input type="file" name="image" id="image"></label>
                                                </div>
                                                <div class="form-group mt-3">
                                                    <textarea class="form-control" name="description" id="description"
                                                              rows="10"
                                                              placeholder="Description...">{{ $banner->description }}
                                                    </textarea>
                                                </div>
                                            </div>
                                            <hr>
                                            <input type="submit" class="btn btn-warning btn-block col-12"
                                                   value="Change">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-danger col-5" data-bs-toggle="modal"
                            data-bs-target="#removeModal-{{ $banner->id }}">Remove Banner
                    </button>
                    <div class="modal fade" id="removeModal-{{ $banner->id }}" tabindex="-1"
                         aria-labelledby="removeModalLabel-{{ $banner->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-dark">
                                    <h5 class="modal-title text-center"
                                        id="removeModalLabel-{{ $banner->id }}">
                                        <strong>Remove Banner</strong>
                                    </h5>
                                </div>
                                <div class="modal-body text-dark">
                                    <div>
                                        You are sure you want to delete this Banner?
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <form action="{{ route('banner.destroy', $banner) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger">Remove</button>
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
