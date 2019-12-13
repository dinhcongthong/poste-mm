$(document).ready(function() {
    loadDataTable();

    changeStatus();
    deleteItem();
    changeTag();
});

function loadDataTable() {
    $('.datatables').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: base_url + '/admin/sub-category/load-data-table',
            dataType: "json",
            type: 'POST'
        },
        "columns": [
            { "data": 'id', 'className': 'text-center' },
            { 'data': 'name' },
            { 'data': 'parent' },
            { 'data': 'tag' },
            { 'data': 'status', 'className': 'text-center' },
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
            url: base_url + '/admin/sub-category/change-status',
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
                    'title': 'Update Sub-Category\'s status',
                    'message': 'Update status successfully',
                    'type': BootstrapDialog.TYPE_SUCCESS
                });
            } else {
                BootstrapDialog.show({
                    'title': 'Update Sub-Category\'s satus',
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
            title: 'Delete An Sub Category',
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
                        url: base_url + '/admin/sub-category/delete',
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
                                    title: 'Delete A Sub Category',
                                    message: 'Delete sub category successfully',
                                    type: BootstrapDialog.TYPE_SUCCESS
                                });
                            } else {
                                var errorText = '';
                                for (var err of data.errors) {
                                    errorText += err + '\n';
                                }
                                BootstrapDialog.show({
                                    title: 'Delete A Sub Category',
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
                                title: 'Delete A Sub Category',
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

function changeTag() {
    if ($('select[name="tag"]').length) {
        $('select[name="tag"]').on('change', function () {
            var tagId = $(this).val();

            $.ajax({
                url: base_url + '/admin/sub-category/get-parent-from-tag',
                method: 'GET',
                data: {
                    'tagId': tagId
                }
            })
            .done(function (data) {
                console.log(data);
                if (data.result) {
                    $('select[name="parent_id"]').html(data.view);

                    $('select[name="parent_id"]').select2('destroy').select2();
                }
            })
            .fail(function (xhr, status, error) {
                console.log(this.url);
                console.log(error);
                console.log(xhr.responseText);
            });
        });
    }
}
