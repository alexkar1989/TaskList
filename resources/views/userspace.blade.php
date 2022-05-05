@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-center font-weight-bold">Мои задачи</h4>
                        <table id="my_task_table" class="table table-striped table-bordered">
                            <thead>
                            <tr class="tasks_row">
                                <th scope="col">№</th>
                                <th scope="col">Заголовок</th>
                                <th scope="col">Стоимость</th>
                                <th scope="col">Дата создания</th>
                                <th scope="col">Дата обновления</th>
                                <th scope="col">Состояние</th>
                                <th scope="col">Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($myTasks))
                                @foreach($myTasks as $task)
                                    <tr class="tasks_row">
                                        <td>{{ $task['id'] }}</td>
                                        <td>{{ $task['title'] }}</td>
                                        <td>{{ $task['cost'] }}</td>
                                        <td>{{ $task['created_at']}}</td>
                                        <td>{{ $task['updated_at']}}</td>
                                        <td class="status">{{ $task['status']}}</td>
                                        <td class="action">
                                            <button id="taskInfo_{{ $task['id'] }}" type="button"
                                                    class="btn btn-primary">Информация
                                            </button>
                                            @if($task['status'] === 'В работе')
                                                <button id="taskCancel_{{ $task['id'] }}" type="button" class="btn btn-danger">Отказаться
                                                </button>
                                                <button id="taskComplete_{{ $task['id'] }}" type="button" class="btn btn-success">Завершить
                                                </button>
                                            @endif()
                                        </td>
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
    @include('dialogs.confirm')
    @include('dialogs.task_info')
@endsection
