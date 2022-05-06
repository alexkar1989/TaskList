/**
 *
 * @param id
 * @returns {Promise<AxiosResponse<any>>}
 */
export const getTaskInfo = async (id) => {
    return await axios.get('/task/' + id);
};

/**
 *
 * @param {numeric}id
 * @returns {Promise<AxiosResponse<any>>}
 */
export const getUsers = async (id = 0) => {
    if (id !== 0) return await axios.get('/user/' + id);
    else return await axios.get('/users');
}

/**
 *
 * @param {string}text
 * @param {function}closure
 */
export const confirmDialog = (text, closure) => {
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
                closure();
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
