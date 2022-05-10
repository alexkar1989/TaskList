<div id="task_info_dialog" style="display: none">
    <div class="card-body">
        <div class="row">
            <h3 id="task_info_id_h3" class="col-sm-5">Номер заявки: <span></span></h3>
        </div>
        <div class="input-group m-3">
            <label class="input-group-text" for="task_info_title">Заголовок</label>
            <input id="task_info_title" type="text" name="task_info_title" class="form-control" disabled readonly/>
        </div>
        <div class="form-control-plaintext m-3">
            <textarea class="form-control" id="task_info_text" name="task_info_text" rows="3"
                      aria-placeholder="Описание" disabled readonly></textarea>
        </div>
        <div>
            <div class="input-group m-3">
                <label class="input-group-text" for="task_info_cost">Стоимость</label>
                <input id="task_info_cost" type="number" name="task_info_cost" class="form-control" disabled readonly/>
            </div>
        </div>
        <div id="taskFiles" style="display: none">
            <div class="form-control m-3">
                <label class="input-group-text mb-2" for="attachedTaskFiles">Файлы</label>
                <ul id="attachedTaskFiles">
                </ul>
            </div>
        </div>
    </div>
</div>
