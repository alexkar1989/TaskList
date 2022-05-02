@extends('layouts.app')
@section('content')
    <div class="container">
        @permission('task_create')
        <div class="m-3">
            <button id="taskAdd_btn" type="button" class="btn btn-primary btn-lg">Создать задачу</button>
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
            <form id="taskAdd_form">
                <div class="form-group m-3">
                    <label for="taskAdd_title">Заголовок</label>
                    <input id="taskAdd_title" type="text" name="title" class="form-control"/>
                </div>
                <div class="form-group m-3">
                    <label for="taskAdd_text">Описание</label>
                    <textarea class="form-control" id="taskAdd_text" name="text" rows="3"></textarea>
                </div>
                <div class="form-group m-3">
                    <label for="taskAdd_cost">Стоимость</label>
                    <input id="taskAdd_cost" type="number" name="cost" class="form-control"/>
                </div>
                <div class="m-3">
                    <label for="taskAdd_files" class="form-label">Подключение файлов</label>
                    <input class="form-control" type="file" id="taskAdd_files" name="files" multiple>
                </div>
            </form>
        </div>
    </div>

    <div id="taskEdit_dialog" style="display: none">
        <div class="card-body">
            <form id="taskEdit_form">
                <div class="row">
                    <h3 id="taskEdit_id_h3" class="col-sm-5">Номер заявки: <span></span></h3>
                    <input type="hidden" id="taskEdit_id">
                </div>
                <div class="input-group m-3">
                    <label class="input-group-text" for="taskEdit_title">Заголовок</label>
                    <input id="taskEdit_title" type="text" name="taskEdit_title" class="form-control"/>
                </div>
                <div class="form-control-plaintext m-3">
                    <textarea class="form-control" id="taskEdit_text" name="taskEdit_text" rows="3"
                              aria-placeholder="Описание"></textarea>
                </div>
                <div>
                    <div class="input-group m-3">
                        <label class="input-group-text" for="taskEdit_cost">Стоимость</label>
                        <input id="taskEdit_cost" type="number" name="taskEdit_cost" class="form-control"/>
                    </div>
                    @permission('task_attach')
                    <div class="input-group m-3">
                        <label class="input-group-text" for="worker_select">Назначить</label>
                        <select id="worker_select" class="form-select form-select-sm"
                                aria-label=".form-select-sm"></select>
                    </div>
                    @endpermission
            </form>
        </div>
    </div>
@endsection
