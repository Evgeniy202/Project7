@extends('admin.layouts.base')
@section('title', 'Create New Category')
@section('content')
    <h1>Створити нову секцію</h1>
    <hr>
    <div class="row">
        <form action="{{ route('sections.store') }}" method="POST">
            @csrf
            <div class="form-group mt-3">
                <input style="text-align: center" type="number" name="priority" id="priority"
                       placeholder="Пріорітет (не обов'язково...)" class="form-control">
            </div>
            <div class="form-group mt-3">
                <input style="text-align: center" type="text" name="title" id="title"
                       placeholder="Назва..." class="form-control" required>
            </div>
            <hr>
            <input type="submit" class="btn btn-success btn-block col-12" value="Створити">
        </form>
    </div>
@endsection
