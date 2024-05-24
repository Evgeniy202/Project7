@extends('admin.layouts.base')
@section('title', 'Користувач '.$user->name)
@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Інформація про користувача: {{ $user->name }}</h2>
    <p><strong>ID:</strong> {{ $user->id }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Роль:</strong> {{ $user->getRoleNames()->implode(', ') }}</p>
    <a href="{{ route('editUserRoleForm', ['id' => $user->id]) }}" class="btn btn-primary">Редагувати роль</a>

    <form method="POST" action="{{ route('deleteUser', ['id' => $user->id]) }}" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Ви впевнені, що хочете видалити користувача?')">Видалити користувача</button>
    </form>
</div>
@endsection
