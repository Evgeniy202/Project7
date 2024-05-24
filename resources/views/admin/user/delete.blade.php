@extends('admin.layouts.base')
@section('title', 'Видалення користувача')
@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Видалення користувача: {{ $user->name }}</h2>
    <p>Ви впевнені, що хочете видалити користувача {{ $user->name }}?</p>
    <form method="POST" action="{{ route('deleteUser', ['id' => $user->id]) }}">
        @csrf
        <button type="submit" class="btn btn-danger">Так, видалити</button>
        <a href="{{ route('findUserById', ['id' => $user->id]) }}" class="btn btn-secondary">Скасувати</a>
    </form>
</div>
@endsection
