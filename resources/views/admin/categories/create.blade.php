@extends('admin.layouts.base')
@section('title', 'Створити нову категорію')
@section('content')
    <h1>Створити нову категорію</h1>
    <hr>
    <div class="row">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="form-group mt-3">
                <input style="text-align: center" type="number" name="priority" id="priority"
                       placeholder="Пріоритет..." class="form-control">
            </div>
            <div class="form-group mt-3">
                <input style="text-align: center" type="text" name="title" id="title"
                       placeholder="Назва..." class="form-control" required>
            </div>
            <div class="form-group mt-3">
                <select class="form-control text-center btn-outline-secondary" name="section">
                    <option value="null">Немає</option>
                    @foreach ($sections as $section)
                        <option value="{{ $section->id }}">{{ $section->title }}</option>
                    @endforeach
                </select>
            </div>
            <hr>
            <input type="submit" class="btn btn-success btn-block col-12" value="Додати">
        </form>
    </div>
@endsection
