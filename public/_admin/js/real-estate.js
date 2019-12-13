$(document).ready(function() {
    /* Update */
    
    deleteRealEstate();
    changeStatus();
    loadDataTable();
    
});

function loadDataTable() {
    $('.rees-datatables').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: base_url + '/admin/real-estate/load-table-data',
            dataType: "json",
            type: 'POST'
        },
        "columns": [
            { "data": 'id', 'className': 'text-center' },
            { 'data': 'name', 'className': 'text-center' },
            { 'data': 'author', 'className': 'text-center' },
            { 'data': 'created_at', 'className': 'text-center' },
            { 'data': 'action', 'className': 'text-center' }
        ],
        "order": [[0, "DESC"]]
    });
}

function deleteRealEstate() {
    $('#table-view').on('click', '.btn-delete', function (e) {
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
                        type: 'Delete an real-estate Article',
                        message: 'Do you really want to delete the real-estate ID: ' + articleId,
                        type: BootstrapDialog.TYPE_DANGER,
                        callback: function (result) {
                            if (result) {
                                $.ajax({
                                    url: base_url + '/admin/real-estate/delete',
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
                                        
                                        loadDataTable();
                                        
                                        deleteRealEstate();
                                        
                                        MyBootstrapShow('Delete real-estate Article', 'Delete Successfully', 'success');
                                    } else {
                                        MyBootstrapShow('Delete real-estate Article', data.error, 'danger');
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

function changeStatus() {
    $('#table-view').on('click', '.change-status', function () {
        var btn = $(this);
        var id = $(this).data('id');
        console.log(id);
        $.ajax({
            url: base_url + '/admin/real-estate/change-status',
            method: 'POST',
            data: {
                'id': id
            }
        })
        .done(function (data) {
            
            // alert(data.result);
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
            console.log(xhr.responseText);
        });
    });
}