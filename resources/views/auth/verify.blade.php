@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Підтвердіть свою електронну адресу') }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('На вашу електронну адресу відправлено нове посилання для підтвердження.') }}
                            </div>
                        @endif

                        {{ __('Перш ніж продовжити, перевірте електронну пошту на наявність листа з посиланням для підтвердження.') }}
                        {{ __('Якщо ви не отримали листа') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('натисніть тут, щоб запросити інший') }}</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
