$(document).ready(function () {
   loadDataTable();

   changeStatus();
    deleteItem();
});

function loadDataTable() {
    $('.datatables').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: base_url + '/admin/category/load-data-table',
            dataType: "json",
            type: 'POST'
        },
        "columns": [
            { "data": 'id', 'className': 'text-center' },
            { 'data': 'name' },
            { 'data': 'tag' },
            { 'data': 'status', 'className': 'text-center'},
            { 'data': 'action', 'className': 'text-center' }
        ],
        "order": [[0, "DESC"]]
    });
}

function changeStatus() {
    $('#table-view').on('click', '.change-status', function (e) {
        e.preventDefault();

        var aTag = $(this);
        var id = $(this).data('id');

        $.ajax({
            method: 'POST',
            url: base_url + '/admin/category/change-status',
            data: {
                'id': id
            }
        })
        .done(function (data) {
            if (data.result) {
                if (data.status) {
                    aTag.html('<i class="fas fa-check-circle text-success"></i>');
                } else {
                    aTag.html('<i class="fas fa-times-circle text-danger"></i>');
                }
                BootstrapDialog.show({
                    'title': 'Update Category\'s status',
                    'message': 'Update status successfully',
                    'type': BootstrapDialog.TYPE_SUCCESS
                });
            } else {
                BootstrapDialog.show({
                    'title': 'Update Category\'s satus',
                    'message': 'Can not find article',
                    'type': BootstrapDialog.TYPE_WARNING
                });
            }
        })
        .fail(function (xhr, status, error) {
            console.log(this.url);
            console.log(error);
        });
    });
}

function deleteItem() {
    $('#table-view').on('click', '.delete-btn', function () {
        var id = $(this).data('id');

        var dialog = BootstrapDialog.confirm({
            title: 'Delete Category',
            message: 'Do you really want to delete selected category? <br/>It\' deteled all data have relationship with selected category.',
            type: BootstrapDialog.TYPE_DANGER,
            closable: true,
            btnCancelLabel: 'Cancel',
            btnOKLabel: 'Delete',
            btnOKClass: 'btn-danger',
            callback: function (result) {
                if (result) {
                    dialog.close();

                    $.ajax({
                        url: base_url + '/admin/category/delete',
                        method: 'POST',
                        data: {
                            'id': id,
                        }
                    })
                    .done(function (data) {
                        console.log(data);
                        if (data.result) {
                            $('.datatables').DataTable().destroy();
                            loadDataTable();

                            BootstrapDialog.show({
                                title: 'Delete a category',
                                message: 'Delete category successfully',
                                type: BootstrapDialog.TYPE_SUCCESS
                            });
                        } else {
                            var errorText = '';
                            for(var err of data.errors) {
                                errorText += err + '\n';
                            }
                            BootstrapDialog.show({
                                title: 'Delete a category',
                                message: errorText,
                                type: BootstrapDialog.TYPE_WARNING
                            });
                        }
                    })
                    .fail(function (xhr, status, error) {
                        console.log(this.url);
                        console.log(error);
                        console.log(xhr.responseText);

                        BootstrapDialog.show({
                            title: 'Delete a category',
                            message: 'Have error in processing',
                            type: BootstrapDialog.TYPE_WARNING
                        });
                    });
                } else {
                    dialog.close();
                }
            }

        })
    });
}
