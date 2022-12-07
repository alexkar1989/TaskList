@extends('layouts.app')
@section('content')
    <div class="container">
        @if(!empty($users))
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="text-center font-weight-bold">Рейтинг пользоателей</h4>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">Фото</th>
                                    <th scope="col">ФИО</th>
                                    <th scope="col">Рейтинг</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <th scope="col"><img class="photo" src="{{ asset('images/noUser.jpg') }}"/></th>
                                        <th scope="col">{{ $user['name'] }}</th>
                                        <th scope="col">
                                            <div class="rating-static">
                                                <input type="radio" id="star-5" name="rating" value="5" @if($user['rating'] == 5) checked @endif>
                                                <label for="star-5" title="Оценка «5»"></label>

                                                <input type="radio" id="star-4" name="rating" value="4" @if($user['rating'] == 4) checked @endif>
                                                <label for="star-4" title="Оценка «4»"></label>

                                                <input type="radio" id="star-3" name="rating" value="3" @if($user['rating'] == 3) checked @endif>
                                                <label for="star-3" title="Оценка «3»"></label>

                                                <input type="radio" id="star-2" name="rating" value="2" @if($user['rating'] == 2) checked @endif>
                                                <label for="star-2" title="Оценка «2»"></label>

                                                <input type="radio" id="star-1" name="rating" value="1" @if($user['rating'] == 1) checked @endif>
                                                <label for="star-1" title="Оценка «1»"></label>
                                            </div>
                                        </th>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection
@push('styles')
    <style>
        .photo {
            width: 30px;
            height: 30px;
        }
    </style>
@endpush
