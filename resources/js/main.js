const {getTaskInfo, getUsers, confirmDialog} = require("./functions");

$(document).ready(function () {
    const $taskEditDialog = $('#task_edit_dialog');
    const $taskAddDialog = $('#task_add_dialog');
    const $tasksTable = $('#task_list_table');
    const $openModal = $("#openModal");

    $openModal.dialog({
        autoOpen: false,
        modal: true,
        resizable: true,
        dialogClass: 'card no-close',
        width: 400,
        closeOnEscape: false,
    });

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
                id: 'task_add_submit_btn',
                text: 'Добавить',
                class: 'btn btn-primary',
                click: function () {
                    axios.put('/task', {
                        title: $('#task_add_title').val(),
                        text: $('#task_add_text').val(),
                        cost: $('#task_add_cost').val(),
                    }).then(r => {
                        $(this).dialog('close');
                        $('#task_add_form').trigger('reset');
                        $tasksTable.DataTable().ajax.reload();
                        toastr.success('Заявка создана успешно');
                    }).catch(e => {
                        toastr.error('Ошибка при добавлении заявки');
                    });
                }
            },
            {
                id: 'task_add_cancel_btn',
                text: 'Отменить',
                class: 'btn btn-danger',
                click: function () {
                    $(this).dialog('close');
                    $('#task_add_form').trigger('reset');
                }
            }
        ]
    });

    $taskEditDialog.dialog({
        autoOpen: false,
        modal: true,
        title: 'Редактировать задачу',
        resizable: true,
        dialogClass: 'card no-close',
        width: 600,
        closeOnEscape: false,
        buttons: [
            {
                id: 'edit_task_submit_btn',
                text: 'Сохранить',
                class: 'btn btn-success',
                click: function () {
                    let taskId = $('#task_edit_id').val();
                    axios.post('/task/' + taskId, {
                        title: $('#task_edit_title').val(),
                        text: $('#task_edit_text').val(),
                        cost: $('#task_edit_cost').val(),
                        worker: $('#worker_select').val(),
                    }).then(() => {
                        $(this).dialog('close');
                        $('#task_edit_form').trigger('reset');
                        $tasksTable.DataTable().ajax.reload();
                        toastr.success('Заявка № ' + taskId + 'успешно обновленна');
                    }).catch(e => {
                        toastr.error('Ошибка при изменении заявки');
                    });
                }
            }, {
                id: 'edit_task_cancel_btn',
                text: 'Закрыть',
                class: 'btn btn-danger',
                click: function () {
                    $(this).dialog('close');
                    $('#task_edit_form').trigger('reset');
                }
            }
        ]
    });

    $('#task_add_btn').on('click', function (e) {
        e.preventDefault();
        $taskAddDialog.dialog('open');
    })

    let $timer,
        $mpageXUp,
        $mpageYUp,
        $mpageXDown,
        $mpageYDown;

    $tasksTable
        .on({
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
                if (event.target.type === 'button') {
                    let [type, id] = event.target.id.split("_");
                    switch (type) {
                        case 'payForWork':
                            alert('А тут создается в бд запись, если нужно ордер в 1с, происходит редирект на платежную систему, ' +
                                'после оплаты ПС отправит success на специальный url. ' +
                                'Результаты платежа подтвержаются. Если нужно, вешается задача для проведения платежа в 1C')
                            break;
                        case 'sendStar':
                            getUsers(id).then(r => {
                                $openModal.on('click', '#rating_btn', function (e) {
                                    let attr = $('.rating-area input[type=radio]:checked').val();
                                    axios.put('/rating/' + id, {rating: attr})
                                        .then(r => {
                                            $openModal.dialog('close')
                                            toastr.success('Успех!');
                                        }).catch(e => {
                                        toastr.error('Ошибка сервера обратитесь к системному администратору');
                                    });
                                    $openModal.off('click');
                                });
                                $openModal.dialog({title: 'Оцените работу, ' + r.data.name}).dialog('open');
                            });
                            break;
                        case 'taskToWork':
                            confirmDialog('Вы уверены, что хотите взять задачу №' + id, () => {
                                axios.post('/user/task/' + id + '/link').then(r => {
                                    let parent = $(event.target).parent();
                                    parent.closest('.tasks_row').remove();
                                    toastr.success('Успех!');
                                }).catch(e => {
                                    toastr.error('Ошибка сервера обратитесь к системному администратору');
                                })
                            });
                            break;
                    }
                } else {
                    $timer = setTimeout(() => {

                        let wSelect = $('#worker_select'),
                            taskId = $(this).children('#taskId').html();

                        getTaskInfo(taskId).then(task => {
                            $('#task_edit_id_h3 span').html(task.data.id);
                            $('#task_edit_id').val(task.data.id);
                            $('#task_edit_title').val(task.data.title);
                            $('#task_edit_text').html(task.data.text);
                            $('#task_edit_cost').val(task.data.cost);

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
                    }, 200);
                }
            },
            dblclick: () => {
                if ($timer) clearTimeout($timer);
            }
        }, '.tasks_row')
        .DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            autoWatch: true,
            stateSave: true,

            ajax: {
                url: "/tasks",
                type: "GET",
                dataSrc: function (data) {
                    return data.data;
                }
            },

            createdRow: function (row, data, dataIndex) {
                $(row).addClass('tasks_row');
            },

            columnDefs: [
                {
                    targets: "_all",
                    createdCell: function (td, cellData, rowData, row, col) {
                        switch (col) {
                            case 0:
                                $(td).attr('id', 'taskId');
                                break;
                            case 5:
                                $(td).attr('class', 'status');
                                break;
                            case 6:
                                $(td).attr('class', 'action');
                                break;
                        }
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
                {data: "action"},
            ],
            language: {
                url: "/js/dataTables.bootstrap.russian.lang"
            },
            stateSaveCallback: function (settings, data) {
                localStorage.setItem('DataTables_' + settings.sInstance, JSON.stringify(data))
            },
            stateLoadCallback: function (settings) {
                return JSON.parse(localStorage.getItem('DataTables_' + settings.sInstance))
            }
        });
});
