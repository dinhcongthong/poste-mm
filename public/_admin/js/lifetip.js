$(document).ready(function() {

    loadDataTable();

    /* Update */
    $('#start-date').datetimepicker({
        format: 'MM-DD-YYYY',
    });
    
    var startDate = $('#start-date').val();
    
    if(startDate) {
        $('#end-date').datetimepicker({
            format: 'MM-DD-YYYY',
            minDate: moment($('#start-date').val(), 'MM-DD-YYYY')
        });
    } else {
        $('#end-date').datetimepicker({
            format: 'MM-DD-YYYY',
        });
    }
    
    $('#start-date').on('dp.change', function(e) {
        $('#end-date').datetimepicker('destroy').datetimepicker({
            format: 'MM-DD-YYYY',
            minDate: e.date
        });
    });

    changeStatus();
    deleteLifetipArticle();

    $('.datatables').DataTable({
        "order": [[0, 'desc']]
    }).on('draw', function() {
        changeStatus();
        deleteLifetipArticle();
    });
    
    $('#publish-date').datetimepicker({
        format: 'MM-DD-YYYY',
    });    
    
    
    // Set CKeditor
    if($('#content-1').length) {
        CKEDITOR.replace('content-1');
        CKEDITOR.replace('content-2');
        CKEDITOR.replace('content-3');
        CKEDITOR.replace('author', {
            toolbar: 'Basic'
        });
    }
    /* CKEDITOR.replace('description', {
        toolbar: 'Basic'
    }); */
});

function changeStatus() {
    $('.change-status').off('click').off('click').on('click', function (e) {
        e.preventDefault();

        var btn = $(this);
        var id = $(this).data('id');
        console.log(id);
        $.ajax({
            url: base_url + '/admin/lifetip/change-status',
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
            console.log(xhr.responseText);
        });
    });
}

function deleteLifetipArticle() {
    $('.btn-delete').off('click').on('click', function (e) {
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
                                    url: base_url + '/admin/lifetip/delete',
                                    method: 'POST',
                                    data: {
                                        'id': articleId
                                    }
                                })
                                .done(function (data) {
                                    if (data.result) {
                                        $('#table-view').html(data.view);
                                        
                                        
                                        $('.datatables').DataTable().destroy();
                                        
                                        $('.datatables').DataTable({
                                            "order": [[0, 'desc']]
                                        });
                                        
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

function loadDataTable() {
    $('.lifetip-datatables').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: base_url + '/admin/lifetip/load-data-table',
            dataType: "json",
            type: 'POST'
        },
        "columns": [
            { "data": 'id',  },
            { 'data': 'name' },
            { 'data': 'user', 'className': 'text-center' },
            { 'data': 'updated-at', 'className': 'text-center' },
            { 'data': 'status', 'className': 'text-center' },
            { 'data': 'action', 'className': 'text-center' }
        ]
    });
}