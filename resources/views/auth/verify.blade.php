@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Подтвердите почту') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Новая ссылка была отправлена на вашу почту.') }}
                        </div>
                    @endif

                    {{ __('Прежде чем продолжить, пожалуйста подтвердите своб почту.') }}
                    {{ __('Если вы не получили email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Нажмите, чтобы поавторить запрос') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
