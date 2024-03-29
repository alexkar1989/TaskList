<div id="task_add_dialog" style="display: none">
    <div class="card-body">
        <form id="task_add_form">
            <div class="form-group m-3">
                <label for="task_add_title">Заголовок</label>
                <input id="task_add_title" type="text" name="task_add_title" class="form-control"/>
            </div>
            <div class="form-group m-3">
                <label for="task_add_text">Описание</label>
                <textarea class="form-control" id="task_add_text" name="task_add_text" rows="3"></textarea>
            </div>
            <div class="form-group m-3">
                <label for="task_add_cost">Стоимость</label>
                <input id="task_add_cost" type="number" name="task_add_cost" class="form-control"/>
            </div>
            @permission('file_attach')
            <div class="m-3">
                <label for="task_add_files" class="form-label">Подключение файлов</label>
                <input class="form-control" type="file" id="task_add_files" name="task_add_files[]" multiple>
            </div>
            @endpermission
        </form>
    </div>
</div>
