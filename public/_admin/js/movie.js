$(document).ready(function () {
    
    if ($('#description').length) {
        CKEDITOR.replace('description', {
            toolbar: 'Basic'
        });
    }
    
    $('#published-date').datetimepicker({
        format: 'MM-DD-YYYY',
    });

    $('.datatables').DataTable({
        "order": [[0, 'desc']]
    }).on('draw', function () {
        changeMovieStatus();
        deleteMovie();
    });
    
    changeMovieStatus();
    deleteMovie();
    
    
});

function changeMovieStatus() {
    $('.btn-change-status').off('click').on('click', function (e) {
        e.preventDefault();
        
        var id = $(this).data('id');
        var btn = $(this);
        
        $.ajax({
            url: base_url + '/admin/movie/change-status',
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
                    title: 'Update Movie\'s status',
                    message: 'Update Movie successfully',
                    type: BootstrapDialog.TYPE_SUCCESS
                });
            } else {
                BootstrapDialog.show({
                    title: 'Update Movie\'s satus',
                    message: data.error,
                    type: BootstrapDialog.TYPE_WARNING
                });
            }
        })
        .fail(function (xhr, status, error) {
            console.log(this.url);
            console.log(error);
            console.log(xhr.responseText);
        })
    });
}

function deleteMovie() {
    $('.btn-delete').off('click').on('click', function (e) {
        e.preventDefault();
        
        var id = $(this).data('id');
        
        BootstrapDialog.confirm({
            title: 'Delete a movie',
            message: 'Deleting a movie will delete all Showtime of this movie.<br/> Do you really want to delete selected movie?',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function (result) {
                if (result) {
                    $.ajax({
                        url: base_url + '/admin/movie/delete',
                        method: 'POST',
                        data: {
                            'id': id
                        }
                    })
                    .done(function (data) {
                        console.log(data);
                        if (data.result) {
                            $('#table-view').html(data.view);
                            
                            $('.datatables').DataTable().destroy();
                            
                            $('.datatables').DataTable({
                                "order": [[0, 'desc']]
                            });
                            
                            deleteMovie();
                            changeMovieStatus();
                        } else {
                            MyBoostrapShow('Delete a movei', data.error, 'warning');
                        }
                    })
                    .fail(function (xhr, status, error) {
                        console.log(this.url);
                        console.log(error);
                        console.log(xhr.responseText);
                    });
                }
            }
        })
    });
}