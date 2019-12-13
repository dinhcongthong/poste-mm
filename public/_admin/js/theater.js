$(document).ready(function() {
    
    if ($('#description').length) {
        CKEDITOR.replace('description', {
            toolbar: 'Basic'
        });
        
        var positionNumber = $('.position-item').length;
        
        for (var i = 0; i < positionNumber; i++) {
            getDistrictFromCity(i + 1);
        }
        
        deleteTheaterPosition();
        
        $('.btn-add-position').on('click', function () {
            positionNumber += 1;
            
            $.ajax({
                url: base_url + '/admin/theater/ajax-add-position',
                method: 'GET',
                data: {
                    'positionNumber': positionNumber,
                }
            })
            .done(function (data) {
                $('#position-list').append(data.view);
                
                $('#city-select-' + positionNumber).select2();
                $('#district-select-' + positionNumber).select2();
                $('#status-select-' + positionNumber).select2({
                    minimumResultsForSearch: -1
                });
                
                getDistrictFromCity(positionNumber);
                deleteTheaterPosition();
            })
            .fail(function (xhr, status, error) {
                console.log(this.url);
                console.log(xhr.responseText);
                console.log(error);
            });
        });
    } else {

        $('.datatables').DataTable({
            "order": [[0, 'desc']]
        }).on('draw', function () {
            deleteAndGetView();
            changeStatus();
        });

        deleteAndGetView();
        changeStatus();
    }
});

/**
* Get district from city
*/
function getDistrictFromCity(i,) {
    $('#city-select-' + i).on('change', function () {
        var id = $(this).val();
        
        $.ajax({
            url: base_url + '/admin/district/get-district-from-city/' + id,
            method: 'GET',
        })
        .done(function (data) {
            if (data.result) {
                $('#district-select-' + i).html(data.view);
                $('#district-select-' + i).select2('destroy').select2();
            } else {
                MyBootstrapShow('Get District List', 'Have Error When Get District', 'warning');
            }
        })
        .fail(function (xhr, status, error) {
            console.log(this.url);
            console.log(xhr.responseText);
        });
    });
}

function deleteTheaterPosition() {
    $('.btn-delete').off('click').on('click', function() {
        var deleteNumber = $(this).data('item');
        var id = $(this).data('id');
        
        BootstrapDialog.confirm({
            title: 'Delete a Position Theater',
            message: 'Do you really want to delete selected position theater? <br/> All data related selected theater positoin will be removed',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function(result) {
                if (result) {
                    if (id == 0) {
                        $('#position-item-' + deleteNumber).remove();
                    } else {
                        $.ajax({
                            url: base_url + '/admin/theater/delete-position',
                            method: 'POST',
                            data: {
                                'id': id
                            }
                        })
                        .done(function(data) {
                            if(data.result) {
                                MyBootstrapShow('Delete Theater Position', 'Delete Theater Position Successfully', 'success');
                                $('#position-item-' + deleteNumber).remove();
                            } else {
                                MyBootstrapShow('Delete Theater Position', data.error, 'danger');
                            }
                        })
                        .fail(function(xhr, status, error) {
                            console.log(this.url);
                            console.log(error);
                            console.log(xhr.responseText);
                        });
                    }
                }
            }
        });
    });
}

function deleteAndGetView() {
    $('.btn-delete').off('click').on('click', function (e) {
        e.preventDefault();
        
        var id = $(this).data('id');
        
        BootstrapDialog.confirm({
            title: 'Delete a Position Theater',
            message: 'Do you really want to delete selected position theater? <br/> All data related selected theater positoin will be removed',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function (result) {
                if (result) {
                    $.ajax({
                        url: base_url + '/admin/theater/position-delete-view',
                        method: 'POST',
                        data: {
                            'id': id
                        }
                    })
                    .done(function (data) {
                        if (data.result) {
                            $('#table-view').html(data.view);
                            
                            
                            $('.datatables').DataTable().destroy();
                            
                            $('.datatables').DataTable({
                                "order": [[0, 'desc']]
                            });
                            
                            deleteAndGetView();
                            
                            MyBootstrapShow('Delete Position Theater', 'Delete Successfully', 'success');
                        } else {
                            MyBootstrapShow('Delete Position Theater', data.error, 'warning');
                        }
                    })
                    .fail(function(xhr, status, error) {
                        console.log(this.url);
                        console.log(error);
                        console.log(xhr.responseText);
                    })
                }
            }
        });
    });
}

function changeStatus() {
    $('.btn-change-status').off('click').on('click', function (e) {
        e.preventDefault();
        
        var id = $(this).data('id');
        var btn = $(this);
        
        $.ajax({
            url: base_url + '/admin/theater/change-status',
            method: 'POST',
            data: {
                'id': id
            }
        })
        .done(function(data) {
            console.log(data);
            if (data.result) {
                if (data.status) {
                    btn.html('<i class="fas fa-check-circle text-success"></i>');
                } else {
                    btn.html('<i class="fas fa-times-circle text-danger"></i>');
                }
                BootstrapDialog.show({
                    title: 'Update Theater\'s status',
                    message: 'Update Theater successfully',
                    type: BootstrapDialog.TYPE_SUCCESS
                });
            } else {
                BootstrapDialog.show({
                    title: 'Update Theater\'s satus',
                    message: data.error,
                    type: BootstrapDialog.TYPE_WARNING
                });
            }
        })
        .fail(function(xhr, status, error) {
            console.log(error);
            console.log(xhr.responseText);
        });
    })
}