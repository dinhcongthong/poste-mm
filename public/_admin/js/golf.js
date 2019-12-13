$(document).ready(function () {
    // Update
    if ($('#description').length) {
        /* CKEDITOR.replace('description', {
            toolbar: 'Basic',
            enterMode: CKEDITOR.ENTER_BR
        }); */
        
        /**
        * Must use off function by have a change event on _admin/js/main.js to catch max file size
        * Upload Image For golf article
        */
        $('input[name="upload_file"]').off('change').on('change', function (e) {
            var input = $(this);
            var id = $('input[name="id"]').val();
            
            for (var i = 0; i < e.target.files.length; i++) {
                var file = e.target.files[i];
                var form_data = new FormData();
                form_data.append('imgFile', file);
                form_data.append('id', id);
                
                $.ajax({
                    url: base_url + '/admin/golf/upload-image',
                    method: 'POST',
                    data: form_data,
                    processData: false,
                    contentType: false,
                    cache: false
                })
                .done(function (data) {
                    if (data.result) {
                        $('#pre-img').append(data.view);
                        
                        deleteImage();
                    } else {
                        if (data.validatorErrors) {
                            var err = '';
                            $.each(data.validatorErrors, function (key, value) {
                                err += value + '<br/>';
                            });
                            BootstrapDialog.show({
                                'title': 'Insert Golf Image',
                                'message': err,
                                'type': BootstrapDialog.TYPE_WARNING
                            });
                        } else {
                            BootstrapDialog.show({
                                'title': 'Insert Golf Image',
                                'message': data.error,
                                'type': BootstrapDialog.TYPE_WARNING
                            });
                        }
                    }
                    input.val('');
                })
                .fail(function (xhr, status, error) {
                    console.log(this.url);
                    console.log(error);
                    console.log(xhr.responseText);
                    input.val('');
                });
            }
        });
        
        deleteImage();
        
        // Load District from city Select
        $('select[name="city_id"]').on('change', function () {
            var id = $(this).val();
            
            $.ajax({
                url: base_url + '/admin/district/get-district-from-city/' + id,
                method: 'GET'
            })
            .done(function (data) {
                if (data.result) {
                    $('select[name="district_id"]').html(data.view);
                    $('select[name="district_id"]').select2('destroy').select2();
                } else {
                    MyBootstrapShow('Get District List', 'Have Error When Get District', 'warning');
                }
            })
            .fail(function (xhr, status, error) {
                console.log(this.url);
                console.log(xhr.responseText);
            });
        });
    } else {
        
        deleteGolf();
        changeStatus();
        
        loadDataTable();
    }
});


function loadDataTable() {
    var type = $('#golf-type').val();
    $('.golf-datatables').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: base_url + '/admin/golf/load-table-data',
            dataType: "json",
            data: { type: type },
            type: 'POST'
        },
        "columns": [
            { "data": 'id', 'className': 'text-center' },
            { 'data': 'name', 'className': 'text-center' },
            { 'data': 'user', 'className': 'text-center' },
            { 'data': 'updated_at', 'className': 'text-center' },
            { 'data': 'status', 'className': 'text-center' },
            { 'data': 'action', 'className': 'text-center' }
        ],
        "order": [[0, "DESC"]]
    });
}

function deleteImage() {
    $('#table-view').off('click', '.btn-delete-golf-img').on('click', '.btn-delete-golf-img', function(e) {
        e.preventDefault();
        
        var btn = $(this);
        var galleryId = $(this).data('id');
        var golfId = $('input[name="id"]').val();
        
        BootstrapDialog.confirm({
            title: 'Delete Golf Image',
            message: 'Do you relly want to delete selected image',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function (result) {
                if(result) {
                    $.ajax({
                        url: base_url + '/admin/golf/delete-image',
                        method: 'POST',
                        data: {
                            'galleryId': galleryId,
                            'golfId': golfId
                        }
                    })
                    .done(function (data) {
                        console.log(data);
                        
                        if (data.result) {
                            $('#pre-img-' + galleryId).remove();
                            
                            MyBootstrapShow('Delete Golf Image', 'Delete Golf Image Successfully', 'success');
                        } else {
                            MyBootstrapShow('Delete Golf Image', data.error, 'warning');
                        }
                    })
                    .fail(function (xhr, status, error) {
                        console.log(this.url);
                        console.log(error);
                        console.log(xhr.responseText);
                    });
                }
            }
        });
    });
}
function deleteGolf() {
    $('#table-view').off('click', '.btn-delete').on('click', '.btn-delete', function (e) {
        e.preventDefault();
        
        var articleId = $(this).data('id');
        var type = $(this).data('type');
        
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
                                    url: base_url + '/admin/golf/delete',
                                    method: 'POST',
                                    data: {
                                        'id': articleId,
                                        'type': type
                                    }
                                })
                                .done(function (data) {
                                    if (data.result) {
                                        $('#table-view').html(data.view);
                                        
                                        
                                        $('.datatables').DataTable().destroy();
                                        
                                        loadDataTable();
                                        
                                        deleteGolf();
                                        changeStatus();
                                        
                                        MyBootstrapShow('Delete  Golf Article', 'Delete Successfully', 'success');
                                    } else {
                                        MyBootstrapShow('Delete Golf Article', data.error, 'danger');
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
    $('#table-view').off('click', '.btn-status').on('click', '.btn-status', function(e) {
        e.preventDefault();
        
        var id = $(this).data('id');
        var btn = $(this);
        
        $.ajax({
            url: base_url + '/admin/golf/change-status',
            method: 'POST',
            data: {
                'id': id
            }
        })
        .done(function(data) {
            if(data.result) {
                if (data.status) {
                    btn.html('<i class="fas fa-check-circle text-success"></i>');
                } else {
                    btn.html('<i class="fas fa-times-circle text-danger"></i>');
                }
                MyBootstrapShow('Change status Article', 'Change Status Article Successfully', 'success');
            } else {
                MyBootstrapShow('Change status Article', data.error, 'warning');
            }
        })
        .fail(function(xhr, status, error) {
            console.log(this.url);
            console.log(error);
            console.log(xhr.responseText);
        });
    })
}