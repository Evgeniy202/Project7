@extends('admin.layouts.base')
@section('title', 'Редагування ролі користувача')
@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Редагування ролі користувача: {{ $user->name }}</h2>
    <form method="POST" action="{{ route('editUserRole', ['id' => $user->id]) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="role">Нова роль:</label>
            <select class="form-control" id="role" name="role">
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Зберегти</button>
    </form>
</div>
@endsection
