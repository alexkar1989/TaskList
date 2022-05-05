/**
 *
 * @param {string|numeric}id
 */
export const getTaskInfo = async (id) => {
    return await axios.get('/task/' + id);
};

export const getUsers = async () => {
    return await axios.get('/users');
}
/**
 *
 * @param {string}text
 * @param clickFunction
 */
export const confirmDialog = (text, clickFunction) => {
    const $confirmDialog = $('#confirm_dialog')
    $confirmDialog.html(text);
    $confirmDialog.dialog({
        autoOpen: false,
        modal: true,
        resizable: false,
        width: 400,
        buttons: [{
            id: 'yes',
            text: 'Да',
            class: 'btn btn-danger',
            click: function () {
                clickFunction();
                $(this).dialog('close');
            }
        },
            {
                id: 'no',
                text: 'Нет',
                class: 'btn btn-default',
                click: function () {
                    $(this).dialog('close');
                }
            }]
    });
    $confirmDialog.dialog('open');
}
