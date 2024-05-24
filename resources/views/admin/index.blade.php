@extends('admin.layouts.base')
@section('title', 'Admin')
@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Графік реєстрації</h2>
    <canvas id="registrationChart" width="400" height="200"></canvas>
</div>

<div class="row mt-4">

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Керування секціями</h3>
                <a href="{{ route('sections.index') }}" class="btn btn-success w-100 mb-3">Всі секції</a>
                <a href="{{ route('sections.create') }}" class="btn btn-success w-100">Додати нову секцію</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Керування категоріями</h3>
                <a href="{{ route('categories.index') }}" class="btn btn-primary w-100 mb-3">Всі категорії</a>
                <a href="{{ route('categories.create') }}" class="btn btn-primary w-100">Створити нову категорію</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Керування продуктами</h3>
                <a href="{{ route('products.index') }}" class="btn btn-info w-100 mb-3">Керування продуктами</a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mt-4">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Керування замовленнями</h3>
                <a href="{{ route('orders-status', 'New') }}" class="btn btn-warning w-100 mb-3">Нові замовлення</a>
                <a href="{{ route('orders-status', 'Processing') }}" class="btn btn-warning w-100 mb-3">Замовлення в обробці</a>
                <a href="{{ route('orders-status', 'Sent') }}" class="btn btn-warning w-100 mb-3">Відправлені замовлення</a>
                <a href="{{ route('orders-status', 'Executed') }}" class="btn btn-warning w-100 mb-3">Виконані замовлення</a>
                <a href="{{ route('orders-status', 'Cancelled') }}" class="btn btn-warning w-100 mb-3">Скасовані замовлення</a>
                <a href="{{ route('search-order') }}" class="btn btn-warning w-100">Пошук замовлення</a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mt-4">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Пошук користувача за ІД</h3>
                <form action="{{ route('searchUserById') }}" method="GET">
                    <div class="form-group mb-3">
                        <label for="userId">Введіть ID користувача:</label>
                        <input type="text" class="form-control" id="userId" name="userId" required>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Пошук</button>
                </form>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        var ctx = document.getElementById('registrationChart').getContext('2d');
        var registrationChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($dates),
                datasets: [{
                    label: 'К-ть реєстрацій',
                    data: @json($counts),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection
