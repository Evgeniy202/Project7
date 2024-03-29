@extends('admin.layouts.base')
@section('title', 'Create New Category')
@section('content')
    <h1>Create New Section</h1>
    <hr>
    <div class="row">
        <form action="{{ route('sections.store') }}" method="POST">
            @csrf
            <div class="form-group mt-3">
                <input style="text-align: center" type="text" name="priority" id="priority"
                       placeholder="Priority (not necessary..." class="form-control">
            </div>
            <div class="form-group mt-3">
                <input style="text-align: center" type="text" name="title" id="title"
                       placeholder="Title..." class="form-control" required>
            </div>
            <hr>
            <input type="submit" class="btn btn-success btn-block col-12" value="Add">
        </form>
    </div>
@endsection
