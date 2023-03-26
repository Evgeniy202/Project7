@extends('admin.layouts.base')
@section('title')
    Admin - {{ $status }} orders
@endsection
@section('content')
    @include('admin.layouts.orders')
@endsection
