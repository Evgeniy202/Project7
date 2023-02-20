@extends('admin.layouts.base')
@section('title')
    Product - {{ $product->title }}
@endsection
@section('content')
    <div class="row">
        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group mt-3">
                <div class="form-group mt-3">
                    <input type="text" name="title" id="title" placeholder="Title..."
                           class="form-control bg-dark text-light" value="{{ $product->title }}">
                </div>
                <div class="form-group mt-3">
                    <input type="text" name="slug" id="slug" placeholder="Marking..."
                           class="form-control bg-dark text-light" value="{{ $product->slug }}">
                </div>
                <div class="form-group mt-3">
                    <textarea class="form-control bg-dark text-light" name="description" id="description" rows="10"
                              placeholder="Description...">{{ $product->description }}</textarea>
                </div>
                <div class="form-group mt-3">
                    <input type="text" name="price" id="price" placeholder="Price..."
                           class="form-control bg-dark text-light" value="{{ $product->price }}">
                </div>
                <div class="form-group mt-3">
                    @if($product->isAvailable == 1)
                        <label>Is available <input type="checkbox" name="isAvailable" id="isAvailable"
                                                   value="1" checked></label>
                    @else
                        <label>Is available <input type="checkbox" name="isAvailable" id="isAvailable"
                                                   value="1"></label>
                    @endif
                </div>
                <div class="form-group mt-3">
                    @if($product->isFavorite == 1)
                        <label>Is favorite <input type="checkbox" name="isFavorite" id="isFavorite"
                                                  value="1" checked></label>
                    @else
                        <label>Is favorite <input type="checkbox" name="isFavorite" id="isFavorite"
                                                  value="1"></label>
                    @endif
                </div>
            </div>
            <input type="submit" class="btn btn-outline-warning btn-block col-md-12" value="Change">
        </form>
        <hr class="mt-2">
        <button type="button" class="btn btn-outline-success col-md-12" data-bs-toggle="modal"
                data-bs-target="#orderDetails-">
            Add New Image
        </button>
        <div class="modal fade" id="orderDetails-" tabindex="-1" aria-labelledby="orderDetailsLabel-"
             aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content text-dark">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="orderDetailsLabel-">
                            Add New Image
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form action="{{ route('addProductImage', $product->id) }}" method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="form-group mt-3">
                                    <div class="form-group mt-3">
                                        <label>Image <input type="file" name="image" id="image" required></label>
                                    </div>
                                    <div class="form-group mt-3">
                                        <input class="col-12" type="text" name="position" id="position"
                                               placeholder="Position...">
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
        @foreach($imagesOfProduct as $image)
            <hr class="mt-2">
            <div class="form-group mt-3">
                <button class="btn btn-outline-" type="button" data-bs-toggle="modal"
                        data-bs-target="#imageDetails-{{ $image->id }}">
                    <img src="{{ asset('/storage/'.$image->image) }}"
                         alt="{{ $product->title }}_{{ $image->position }}">
                </button>
                <div class="modal fade" id="imageDetails-{{ $image->id }}" tabindex="-1"
                     aria-labelledby="imageDetailsLabel-{{ $image->id }}"
                     aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content text-dark">
                            <div class="modal-header bg-dark">
                                <h5 class="modal-title text-light text-center" id="imageDetails-{{ $image->id }}">
                                    Image: {{ $product->title }}_{{ $image->position }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body bg-dark">
                                <div class="row text-light">
                                    <img src="{{ asset('/storage/'.$image->image) }}"
                                         alt="{{ $product->title }}_{{ $image->position }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('changeProductImage', [$product->id, $image->id]) }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="form-group mt-3">
                    <label class="col">Position<input type="text" name="position" id="position"
                                                      placeholder="Position..."
                                                      class="form-control bg-dark text-light"
                                                      value="{{ $image->position }}"></label>
                </div>
                <div class="form-group mt-3">
                    @if($image->isMain == 1)
                        <label>Is Main<input type="checkbox" name="isMain" id="isMain"
                                             value="1" checked></label>
                    @else
                        <label>Is Main<input type="checkbox" name="isMain" id="isMain"
                                             value="1"></label>
                    @endif
                </div>
                <input type="submit" class="btn btn-warning col-2" value="Change Image">
            </form>
            <div class="container">
                <button class="btn btn-danger col-2" data-bs-toggle="modal"
                        data-bs-target="#removeModal-{{ $image->id }}">Remove Image
                </button>
            </div>
            <div class="modal fade" id="removeModal-{{ $image->id }}" tabindex="-1"
                 aria-labelledby="removeModalLabel-{{ $image->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header text-dark">
                            <h5 class="modal-title text-center"
                                id="removeModalLabel-{{ $image->id }}">
                                <strong>Remove Image</strong>
                            </h5>
                        </div>
                        <div class="modal-body text-dark">
                            <div>
                                You are sure you want to delete this image?
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <a href="{{ route('destroyProductImage', [$product->id, $image->id]) }}"
                               class="btn btn-outline-danger">Remove</a>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="mt-2">
        @endforeach
        <hr class="mt-2">
        <button type="button" class="btn btn-outline-success col-md-12" data-bs-toggle="modal"
                data-bs-target="#orderDetails-">
            Add New Feature
        </button>
        <div class="modal fade" id="orderDetails-" tabindex="-1" aria-labelledby="orderDetailsLabel-"
             aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content text-dark">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="orderDetailsLabel-">
                            Add New Feature
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form action="#" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group mt-3">

                                </div>
                                <hr>
                                <input type="submit" class="btn btn-success btn-block col-12" value="Add">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach($featuresView as $featureView)

        @endforeach
    </div>
@endsection
