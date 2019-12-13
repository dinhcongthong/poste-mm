$(document).ready(function () {
    changeLetter();
    changeRole();
    deleteUser();
    changeStatus();
    loadTableData()
});

function loadTableData () {
    $('.user-datatables').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: base_url + '/admin/user/load-table-data',
            dataType: "json",
            type: 'POST'
        },
        "columns": [
            { 'data': 'id', 'className': 'text-center' },
            { 'data': 'name' },
            { 'data': 'isLetter' },
            { 'data': 'permission' },
            { 'data': 'updated_at', 'className': 'text-center' },
            { 'data': 'status', 'className': 'text-center' },
            { 'data': 'action', 'className': 'text-center' }
        ]
    });
}

function changeLetter() {
    $('#table-view').off('change', '.sl-change-letter').on('change', '.sl-change-letter', function () {
        var btn = $(this);
        var id = $(this).data('id');

        $.ajax({
            url: base_url + '/admin/user/change-letter',
            method: 'POST',
            data: {
                'id': id
            }
        })
            .done(function (data) {
                if (data.result) {
                    BootstrapDialog.show({
                        'title': 'Update News Letter status',
                        'message': 'Update News Letter status successfully',
                        'type': BootstrapDialog.TYPE_SUCCESS
                    });
                } else {
                    BootstrapDialog.show({
                        'title': 'Update News Letter status',
                        'message': data.error,
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

function changeRole() {
    $('#table-view').off('change', '.sl-change-role').on('change', '.sl-change-role', function () {
        var btn = $(this);
        var id = $(this).data('id');
        var type_id = $(this).val();

        $.ajax({
            url: base_url + '/admin/user/change-role',
            method: 'POST',
            data: {
                'id': id,
                'type_id': type_id
            }
        })
            .done(function (data) {
                if (data.result) {
                    BootstrapDialog.show({
                        'title': 'Update Permission status',
                        'message': 'Update Permission status successfully',
                        'type': BootstrapDialog.TYPE_SUCCESS
                    });
                } else {
                    BootstrapDialog.show({
                        'title': 'Update Permission satus',
                        'message': data.error,
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

function changeStatus() {
    $('#table-view').off('click', '.btn-change-status').on('click', '.btn-change-status', function () {
        var btn = $(this);
        var id = $(this).data('id');

        $.ajax({
            url: base_url + '/admin/user/change-status',
            method: 'POST',
            data: {
                'id': id
            }
        })
            .done(function (data) {
                if (data.result) {
                    if (data.status) {
                        btn.html('<i class="fas fa-check-circle text-success"></i>');
                    } else {
                        btn.html('<i class="fas fa-times-circle text-danger"></i>');
                    }

                    BootstrapDialog.show({
                        'title': 'Update User status',
                        'message': 'Update User status successfully',
                        'type': BootstrapDialog.TYPE_SUCCESS
                    });
                } else {
                    BootstrapDialog.show({
                        'title': 'Update User status',
                        'message': data.error,
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

function deleteUser() {
    $('#table-view').off('click', '.btn-delete').on('click', '.btn-delete', function (e) {
        alert("ok");
        e.preventDefault();
        var articleId = $(this).data('id');
        var btn = $(this);
        
        var x = Math.floor((Math.random() * 10) + 1);
        var y = Math.floor((Math.random() * 10) + 1);
        
        BootstrapDialog.show({
            title: 'Are you conscious?',
            message: x + ' + ' + y + ' = ? <br/><input class="form-control" />',
            buttons: [{
                cssClass: 'btn-primary',
                hotkey: 13, //Enter
                label: 'Of course!',
                action: function (dialogRef) {
                    var value = dialogRef.getModalBody().find('input').val();
                    value = parseInt(value);
                    
                    if (value != x + y) {
                        return false;
                    }
                    
                    dialogRef.close();
                    
                    BootstrapDialog.confirm({
                        type: 'Delete an Dailyinfo Article',
                        message: 'Do you really want to delete the article ID: ' + articleId,
                        type: BootstrapDialog.TYPE_DANGER,
                        callback: function (result) {
                            if (result) {
                                $.ajax({
                                    url: base_url + '/admin/user/delete',
                                    method: 'POST',
                                    data: {
                                        'id': articleId
                                    }
                                })
                                .done(function (data) {
                                    console.log(data);
                                    if (data.result) {
                                        $('#table-view').html(data.view);
                                        
                                        
                                        $('.datatables').DataTable().destroy();
                                        
                                        loadTableData();

                                        deleteLifetipArticle();
                                        
                                        MyBootstrapShow('Delete News Article', 'Delete Successfully', 'success');
                                    } else {
                                        MyBootstrapShow('Delete News Article', data.error, 'danger');
                                    }
                                })
                                .fail(function (xhr, status, error) {
                                    console.log(this.url);
                                    console.log(xhr.responseText);
                                });
                            }
                        }
                    })
                }
            }]
        })
    });
}