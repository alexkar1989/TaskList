@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-center font-weight-bold">Мои задачи</h4>
                        <table id="my_task_table" class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">№</th>
                                <th scope="col">Заголовок</th>
                                <th scope="col">Стоимость</th>
                                <th scope="col">Дата создания</th>
                                <th scope="col">Дата обновления</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($myTasks))
                                @foreach($myTasks as $task)
                                    <tr>
                                        <td>{{ $task['id'] }}</td>
                                        <td>{{ $task['title'] }}</td>
                                        <td>{{ $task['cost'] }}</td>
                                        <td>{{ $task['created_at']}}</td>
                                        <td>{{ $task['updated_at']}}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
