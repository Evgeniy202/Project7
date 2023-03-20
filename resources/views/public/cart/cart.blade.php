@extends('layouts.app')
@section('title', 'Project - Your Cart')
@section('content')
    @php
        $generalPrice = 0;
    @endphp
    <div class="container">
        @if(!empty($products[0]))
            <table class="table text-dark">
                <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Image</th>
                    <th scope="col">Price</th>
                    <th scope="col">Number</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $cartProduct)
                    @php
                        $price = $cartProduct->price * $cartProduct->number;
                        if(!empty($discounts[$cartProduct->id])) {
                            $price = $price - $discounts[$cartProduct->id];
                        }

                        $generalPrice += $price;
                    @endphp
                    <tr>
                        <th scope="row"><a
                                href="{{ route('redirect-to-product', $cartProduct->id) }}">{{ $cartProduct->title }}</a>
                        </th>
                        <td><a href="{{ route('redirect-to-product', $cartProduct->id) }}"><img
                                    src="{{ asset('/storage/'.$cartProduct->image) }}"
                                    class="img-fluid rounded" style="width: 50px"></a></td>
                        <td>${{ $price }}</td>
                        <td>
                            <form action="{{ route('change-quantity', $cartProduct->cart_prod_id) }}"
                                  method="POST">
                                @csrf
                                <input type="number" class="form-control col-md-12" name="number" min="1"
                                       value="{{ $cartProduct->number }}">
                                <br>
                                <input type="submit" class="btn btn-primary col-md-12" value="Change Quantity">
                            </form>
                            <a href="{{ route('remove-from-cart', $cartProduct->cart_prod_id) }}"
                               class="btn btn-danger col-md-12 mt-2">Remove</a>
                        </td>
                @endforeach
                </tbody>
            </table>
            <h5>General price: ${{ $generalPrice }}</h5>
            <hr>
            <div class="">
                <a href="#" class="btn btn-outline-success col-7 m-1">Make order</a>
                <a href="{{ route('all-remove-from-cart') }}" class="btn btn-outline-danger col-4 m-1">Clean cart</a>
            </div>
        @else
            <h3 class="text-center">Empty</h3>
        @endif
    </div>
@endsection
