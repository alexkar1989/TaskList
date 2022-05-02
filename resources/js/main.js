$(document).ready(function () {
    const $taskEditDialog = $('#taskEdit_dialog');
    const $taskAddDialog = $('#taskAdd_dialog');
    const $tasksTable = $('#task_list_table');

    //const $taskDialog = $('#task_dialog');
    // /**
    //  *
    //  * @param action
    //  * @param {{id:number,title:string,text:string,cost:number}} data
    //  * @returns {string}
    //  */
    // function openTask(action, data = {}) {
    //     if ($.isEmptyObject(data)) data = {
    //         id: 0,
    //         title: "",
    //         text: "",
    //         cost: 0
    //     }
    //     let task = '' +
    //         '<div class="card-body">' +
    //         '   <div class="form-group row">\n' +
    //         '       <h3 class="col-sm-5">Номер заявки:</h3>' +
    //         '       <h3 id="taskEdit_id" class="col-sm-2">' + data.id ?? "" + '</h3>' +
    //         '   </div>\n' +
    //         '   <div class="form-group m-3">\n' +
    //         '       <label for="taskEdit_title">Заголовок</label>\n' +
    //         '       <input id="taskEdit_title" type="text" name="taskEdit_title" class="form-control" value="' + data.title ?? "" + '"/>\n' +
    //         '   </div>\n' +
    //         '   <div class="form-group m-3">\n' +
    //         '       <label for="taskEdit_text">Описание</label>\n' +
    //         '    <textarea class="form-control" id="taskEdit_text" name="taskEdit_text" rows="3">' + data.text ?? "" + '</textarea>\n' +
    //         '   </div>\n' +
    //         '   <div class="form-group m-3">\n' +
    //         '       <label for="taskEdit_cost">Стоимость</label>\n' +
    //         '    <input id="taskEdit_cost" type="number" name="taskEdit_cost" class="form-control" value="' + data.cost ?? 0 + '"/>\n' +
    //         '   </div>' +
    //         '</div>';
    //     if (action === 'add') {
    //         return task;
    //     }
    // }

    // $taskDialog.dialog({
    //     autoOpen: false,
    //     modal: true,
    //     title: 'Добавить задачу',
    //     resizable: true,
    //     dialogClass: 'card no-close',
    //     width: 600,
    //     closeOnEscape: false,
    // });

    $('#taskAdd_btn').on('click', function (e) {
        e.preventDefault();
        $taskAddDialog.dialog('open');
    })

    const getTaskInfo = async (id) => {
        return await axios.get('/task/' + id);
    };

    $taskAddDialog.dialog({
        autoOpen: false,
        modal: true,
        title: 'Добавить задачу',
        resizable: true,
        dialogClass: 'card no-close',
        width: 600,
        closeOnEscape: false,
        buttons: [
            {
                id: 'taskAdd_submit_btn',
                text: 'Добавить',
                class: 'btn btn-primary',
                click: function () {
                    axios.put('/task', {
                        title: $('#taskAdd_title').val(),
                        text: $('#taskAdd_text').val(),
                        cost: $('#taskAdd_cost').val(),
                    }).then(r => {
                        $(this).dialog('close');
                        $('#taskAdd_form').trigger('reset');
                        $tasksTable.DataTable().ajax.reload();
                        toastr.success('Заявка создана успешно');
                    }).catch(e => {
                        toastr.error('Ошибка при добавлении заявки');
                    });
                }
            },
            {
                id: 'taskAdd_cancel_btn',
                text: 'Отменить',
                class: 'btn btn-danger',
                click: function () {
                    $(this).dialog('close');
                    $('#taskAdd_form').trigger('reset');
                }
            }
        ]
    });

    $taskEditDialog.dialog({
        autoOpen: false,
        modal: true,
        title: 'Добавить задачу',
        resizable: true,
        dialogClass: 'card no-close',
        width: 600,
        closeOnEscape: false,
        buttons: [
            {
                id: 'editTask_submit_btn',
                text: 'Сохранить',
                class: 'btn btn-success',
                click: function () {
                    let taskId = $('#taskEdit_id').val();
                    axios.post('/task/' + taskId, {
                        title: $('#taskEdit_title').val(),
                        text: $('#taskEdit_text').val(),
                        cost: $('#taskEdit_cost').val(),
                        worker: $('#worker_select').val(),
                    }).then(() => {
                        $(this).dialog('close');
                        $('#taskEdit_form').trigger('reset');
                        $tasksTable.DataTable().ajax.reload();
                        toastr.success('Заявка № ' + taskId + 'успешно обновленна');
                    }).catch(e => {
                        toastr.error('Ошибка при изменении заявки');
                    });
                }
            }, {
                id: 'editTask_cancel_btn',
                text: 'Закрыть',
                class: 'btn btn-danger',
                click: function () {
                    $(this).dialog('close');
                    $('#taskEdit_form').trigger('reset');
                }
            }
        ]
    });

    const getUsers = async () => {
        return await axios.get('/users');
    }

    let $timer,
        $mpageXUp,
        $mpageYUp,
        $mpageXDown,
        $mpageYDown;

    $tasksTable.on({
        mousedown: (event) => {
            $mpageXDown = event.pageX;
            $mpageYDown = event.pageY;
        },
        mouseup: (event) => {
            $mpageXUp = event.pageX;
            $mpageYUp = event.pageY;
        },
        click: function (event) {
            if ($mpageXDown !== $mpageXUp || $mpageYDown !== $mpageYUp) return;
            if ($timer) clearTimeout($timer);
            $timer = setTimeout(() => {
                let parent = $(event.target).parent();
                //if (parent[0].id === 'status') return;
                if (event.target.type === 'button') {
                    console.log('button');
                } else {
                    let wSelect = $('#worker_select'),
                        taskId = $(this).children('#taskId').html();


                    getTaskInfo(taskId).then(task => {
                        $('#taskEdit_id_h3 span').html(task.data.id);
                        $('#taskEdit_id').val(task.data.id);
                        $('#taskEdit_title').val(task.data.title);
                        $('#taskEdit_text').html(task.data.text);
                        $('#taskEdit_cost').val(task.data.cost);

                        wSelect.find('option').remove();

                        getUsers().then(r => {
                            wSelect.append("<option value=''></option>");
                            r.data.forEach((user) => {
                                wSelect.append("<option value=" + user.id + ">" + user.name + "</option>");
                            });
                            if (task.data.user_id !== null) {
                                $('#worker_select option[value=' + task.data.user_id + ']').prop('selected', 'selected');
                            }
                        });
                        $taskEditDialog.dialog('open');
                    });
                }
            }, 200);
        },
        dblclick: () => {
            if ($timer) clearTimeout($timer);
        }
    }, '.tasks_row').DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        ordering: false,
        paging: false,
        searching: false,
        info: false,
        autoWatch: true,
        ajax: {
            url: "/tasks",
            type: "GET",
            dataSrc: function (data) {
                return data;
            }
        },
        createdRow: function (row, data, dataIndex) {
            $(row).addClass('tasks_row');
        },
        columnDefs: [
            {
                targets: "_all",
                createdCell: function (td, cellData, rowData, row, col) {
                    if (col === 0) $(td).attr('id', 'taskId');
                    if (col === 5) $(td).attr('id', 'status');
                }
            },
        ],
        columns: [
            {data: "id"},
            {data: "title"},
            {data: "cost"},
            {data: "created_at"},
            {data: "updated_at"},
            {data: "status"},
        ],
        language: {
            url: "/js/dataTables.bootstrap.russian.lang"
        },
    });

});
