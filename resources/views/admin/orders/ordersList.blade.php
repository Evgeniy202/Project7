@extends('admin.layouts.base')
@section('title')
    Admin - {{ $status }} замовлень
@endsection
@section('content')
    @include('admin.layouts.orders')
@endsection
