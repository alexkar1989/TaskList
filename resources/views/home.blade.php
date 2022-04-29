@extends('layouts.app')
@section('content')
    <div class="container">
        @role('create_task')
        <button id="addTask_btn" type="button" class="btn btn-primary btn-lg">Создать заявку</button>
        @endrole
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-center font-weight-bold">Список заявок</h4>
                        <table id="task_list_table" class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">№</th>
                                <th scope="col">Заголовок</th>
                                <th scope="col">Текст</th>
                                <th scope="col">Стоимость</th>
                                <th scope="col">Исполнитель</th>
                                <th scope="col"></th>
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
    <div id="taskAdd_dialog" style="display: none">
        <div class="card-body">
            <form id="addTask_form" method="POST" action="/task">
                @csrf
                @method('PUT')
                <div class="form-group m-3">
                    <label for="addTask_title">Заголовок</label>
                    <input id="addTask_title" type="text" name="addTask_title" class="form-control"/>
                </div>
                <div class="form-group m-3">
                    <label for="addTask_text">Описание</label>
                    <textarea class="form-control" id="addTask_text" name="addTask_text" rows="3"></textarea>
                </div>
                <div class="form-group m-3">
                    <label for="addTask_cost">Стоимость</label>
                    <input id="addTask_cost" type="number" name="addTask_cost" class="form-control"/>
                </div>
            </form>
        </div>
    </div>
    <div id="taskInfo_dialog" style="display: none">
        <div class="card-body">
            <form id="addTask_form" method="POST" action="/task">
                @csrf
                @method('PUT')
                <div class="form-group m-3">
                    <label for="addTask_title">Заголовок</label>
                    <input id="addTask_title" type="text" name="addTask_title" class="form-control"/>
                </div>
                <div class="form-group m-3">
                    <label for="addTask_text">Описание</label>
                    <textarea class="form-control" id="addTask_text" name="addTask_text" rows="3"></textarea>
                </div>
                <div class="form-group m-3">
                    <label for="addTask_cost">Стоимость</label>
                    <input id="addTask_cost" type="number" name="addTask_cost" class="form-control"/>
                </div>
                @role('attache_file')
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Назначить</label>
                    <select class="form-control" id="exampleFormControlSelect1">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>
                @endrole
            </form>
        </div>
    </div>
@endsection
