$(document).ready(function () {
    let $taskInfoDialog = $('#taskInfo_dialog');
    let $taskAddDialog = $('#taskAdd_dialog');
    let $tasksTable = $('#task_list_table');


    $taskAddDialog.dialog({
        autoOpen: false,
        modal: true,
        title: 'Добавить задачу',
        resizable: true,
        dialogClass: 'card no-close',
        width: 600,
        closeOnEscape: false,
        buttons: [{
            id: 'addTask_submit_btn',
            text: 'Добавить',
            class: 'btn btn-primary',
            click: () => {
                axios.put('/task', {
                    title: $('#addTask_title').val(),
                    text: $('#addTask_text').val(),
                    cost: $('#addTask_cost').val(),
                }).then(r => {
                    $tasksTable.DataTable().ajax.reload();
                    $('#addTask_form').trigger('reset');
                    toastr.success('Заявка создана успешно');
                    $taskAddDialog.dialog('close');
                }).catch(e => {
                    console.log(e);
                    toastr.error('Ошибка при добавлении заявки');
                });
            }
        }]

    });

    $tasksTable.on('click', '.tasks_row', function (e) {
        let taskId = $(this).children('#taskId').html();
        console.log(taskId);
    }).DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        ordering: false,
        paging: false,
        searching: false,
        lengthChange: false,
        info: false,
        autoWatch: true,
        ajax: {
            url: "/tasks",
            type: "GET",
            dataSrc: function (data) {
                //console.log(data);
                // $ips = data;
                // for (let i = 0; i < data.length; i++) {
                //     data[i]['change'] = "<button id='editIp' class='btn btn-primary btn-sm' data-id='" + i + "'>Редактировать</button>";
                // }
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
                }
            },
        ],
        columns: [
            {data: "id"},
            {data: "title"},
            {data: "text"},
            {data: "cost"},
        ],
        language: {
            url: "/js/dataTables.bootstrap.russian.lang"
        },
    });

    $('#addTask_btn').on('click', function (e) {
        e.preventDefault();
        $addTaskDialog.dialog('open');
    })

});
