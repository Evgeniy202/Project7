@extends('layouts.app')
@section('title', 'Search')
@section('content')
<main class="container bg-light text-dark rounded-2">
    <header class="section-heading">
        <h1 class="section-title">Searching Result:</h1>
    </header>
    <hr>
    @include('layouts.products')
</main>
@endsection
