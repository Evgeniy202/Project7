<div class="row">
    @foreach($products as $product)
        <div class="col-lg-3 col-md-5 col-sm-5 bg-gradient m-4">
            <figure class="card-product-grid">
                <div class="bg-light rounded mt-2">
                    <a href="#"
                       class="img-wrap rounded bg-gray-light">
                        <img height="100" class="mix-blend-multiply mt-4 m-5 rounded"
                             src="{{ asset('/storage/'.$images[$product->id]) }}"
                             alt="{{ $product->title }}">
                    </a>
                </div>
                <figcaption class="pt-2">
                    @if (!empty(Auth::user()->id))
                        <a id="selectBtn-{{ $product->id }}"
                           href="#"
                           class="float-end btn btn-light btn-outline-danger"><i
                                class="bi bi-heart">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                     fill="currentColor" class="bi bi-heart"
                                     viewBox="0 0 16 16">
                                    <path
                                        d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                                </svg>
                            </i></a>
                    @else
                        <a id="selectBtn-{{ $product->id }}"
                           href="{{ route('login') }}"
                           class="float-end btn btn-light btn-outline-danger"><i
                                class="bi bi-heart">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                     fill="currentColor" class="bi bi-heart"
                                     viewBox="0 0 16 16">
                                    <path
                                        d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                                </svg>
                            </i></a>
                    @endif
                    <b>
                        <a href="#"
                           class="title text-danger">{{ $product->title }}</a>
                    </b>
                    <br>
                    <small class="text-muted">{{ $currentCategory->title }}</small>
                    <br>
                    <strong class="price">{{ $product->price }} $</strong> <!-- price.// -->
                </figcaption>
            </figure>
        </div> <!-- col end.// -->
    @endforeach
</div>
<hr>
<footer class="d-flex mt-4">
    {{ $products->links() }}
</footer>
