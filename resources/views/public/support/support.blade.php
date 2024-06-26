@extends('layouts.app')
@section('title', 'Project7 - Support')
@section('content')
    <div class="container">
        <h3>Підтримка</h3>
        <hr>
        <div class="text-dark">
            <div class="col-md-12">
                <h3 class=""></h3>
                <form action="{{ route('create-support') }}" method="POST" class="p-5">
                    @csrf
                    <input type="text" id="name" name="name" class="form-control m-2" placeholder="Ваше ім'я..."
                           required>
                    <input type="text" id="contact" name="contact" class="form-control m-2"
                           placeholder="Введіть ваш номер телефону або електронну пошту..." required>
                    <textarea id="information" name="information" class="form-control m-2" rows="5"
                              placeholder="Опишіть причину вашого звернення..." required></textarea>
                    <input type="submit" class="btn btn-outline-success m-2 col-12" value="Відправити заявку">
                </form>
            </div>
        </div>
    </div>
@endsection
