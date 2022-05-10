@extends('layouts.app')
@section('content')
    <div class="container">
        @permission('task_create')
        <div class="m-3">
            <button id="task_add_btn" type="button" class="btn btn-primary btn-lg">Создать задачу</button>
        </div>
        @endpermission
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-center font-weight-bold">Список задач</h4>
                        <table id="task_list_table" class="table table-striped">
                            <thead>
                            <tr>
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('dialogs.task_add')
    @role('worker')
    @include('dialogs.task_info')
    @endrole
    @notrole('worker')
    @include('dialogs.task_edit')
    @endrole
    @include('dialogs.confirm')
    @include('dialogs.rating')
@endsection

