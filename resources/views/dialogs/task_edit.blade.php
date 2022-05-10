<div id="task_edit_dialog" style="display: none">
    <div class="card-body">
        <form id="task_edit_form">
            <div class="row">
                <h3 id="task_edit_id_h3" class="col-sm-5">Номер заявки: <span></span></h3>
                <input type="hidden" id="task_edit_id">
            </div>
            <div class="input-group m-3">
                <label class="input-group-text" for="task_edit_title">Заголовок</label>
                <input id="task_edit_title" type="text" name="task_edit_title" class="form-control"/>
            </div>
            <div class="form-control-plaintext m-3">
                    <textarea class="form-control" id="task_edit_text" name="task_edit_text" rows="3"
                              aria-placeholder="Описание"></textarea>
            </div>
            <div>
                <div class="input-group m-3">
                    <label class="input-group-text" for="task_edit_cost">Стоимость</label>
                    <input id="task_edit_cost" type="number" name="task_edit_cost" class="form-control"/>
                </div>
                @permission('task_attach')
                <div class="input-group m-3">
                    <label class="input-group-text" for="worker_select">Назначить</label>
                    <select id="worker_select" class="form-select form-select-sm" name="task_edit_worker"
                            aria-label=".form-select-sm"></select>
                </div>
                @endpermission
            </div>
            @permission('file_attach')
            <div class="m-3">
                <label for="task_edit_files" class="form-label">Подключение файлов</label>
                <input class="form-control" type="file" id="task_edit_files" name="task_edit_files[]" multiple>
            </div>
            @endpermission
            <div id="taskFiles" style="display: none">
                <div class="form-control m-3">
                    <label class="input-group-text mb-2" for="attachedTaskFiles">Файлы</label>
                    <ul id="attachedTaskFiles"></ul>
                </div>
            </div>
        </form>
    </div>
</div>
