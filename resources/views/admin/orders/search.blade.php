@extends('admin.layouts.base')
@section('title', 'Admin - Search Order')
@section('content')
    <form class="form-inline mt-2 mt-md-0 row mb-4" method="GET"
          action="{{ route('search-order') }}">
        <input name="search" id="search" class="mr-sm-2 col-md-9 bg-light" type="text"
               placeholder="Search by number of order"
               aria-label="Search" required>
        <button class="btn btn-outline-primary my-2 my-sm-0 col-md-2" type="submit">Пошук</button>
        <a href="{{ route('orders-status', 'Search') }}"
           class="btn btn-outline-secondary my-2 my-sm-0 col-md-1">Скинути
        </a>
    </form>
    @include('admin.layouts.orders')
@endsection
