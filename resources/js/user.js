import {confirmDialog, getTaskInfo} from "./functions";

$(document).ready(function () {
    const $taskInfoDialog = $('#task_info_dialog');
    const $myTaskTable = $('#my_task_table');

    $('[id^=taskInfo_]').click(function (e) {
        let [type, taskId] = this.id.split('_');
        getTaskInfo(taskId).then(task => {
            $('#task_info_id_h3 span').html(task.data.id);
            $('#task_info_id').val(task.data.id);
            $('#task_info_title').val(task.data.title);
            $('#task_info_text').html(task.data.text);
            $('#task_info_cost').val(task.data.cost);

            if (task.data.files.length !== 0) {
                $('#taskFiles').show();
                $('#attachedTaskFiles').find('li').remove();
                task.data.files.forEach(file => {
                    $('#attachedTaskFiles').append('<li><a href="/getFile/' + task.data.id + '/' + file.id + '">' + file.name + '</a></li>');
                });
            }
            $taskInfoDialog.dialog('open');
        })
    })

    $('[id^=taskComplete_]').click(function (e) {
        let [type, taskId] = this.id.split('_');

        confirmDialog('Вы уверены, что хотите взять задачу №' + taskId, () => {
            axios.post('/user/task/' + taskId + '/complete').then(r => {
                let row = $(this).closest('.tasks_row');
                row.find('.status').html('Завершена');
                $('#taskCancel_' + taskId).hide();
                $(this).hide();
                toastr.success('Успех!');
            }).catch(e => {
                toastr.error('Ошибка сервера обратитесь к системному администратору');
            })
        });
    })

    $('[id^=taskCancel_]').click(function (event) {
        let [type, taskId] = this.id.split('_');
        confirmDialog('Вы уверены, что хотите взять отказаться от выполнения задачи №' + taskId, () => {
            axios.post('/user/task/' + taskId + '/cancel').then(r => {
                let parent = $(event.target).parent();
                parent.closest('.tasks_row').remove();
                toastr.success('Успех!');
            }).catch(e => {
                console.log(e);
                toastr.error('Ошибка сервера обратитесь к системному администратору');
            })
        });
    })

    $taskInfoDialog.dialog({
        autoOpen: false,
        modal: true,
        title: 'Добавить задачу',
        resizable: true,
        dialogClass: 'card no-close',
        width: 600,
        closeOnEscape: false,
        buttons: [
            {
                id: 'info_close_btn',
                text: 'Закрыть',
                class: 'btn btn-danger',
                click: function () {
                    $(this).dialog('close');
                }
            }
        ]
    });

    $myTaskTable.DataTable({
        stateSave: true,
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
})
