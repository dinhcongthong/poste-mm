$(document).ready(function() {
    
    if ($('#description').length) {
        CKEDITOR.replace('description', {
            toolbar: 'Basic'
        });
    }
    var positionNumber = $('.position-item').length;
    
    for(var i = 0; i < positionNumber; i++) {
        getDistrictFromCity(i + 1);
    }
    
    deleteTheaterPosition();
    
    $('.btn-add-position').on('click', function() {
        positionNumber += 1;
        
        $.ajax({
            url: base_url + '/admin/theater/ajax-add-position',
            method: 'GET',
            data: {
                'positionNumber': positionNumber,
            }
        })
        .done(function(data) {
            console.log(data);
            $('#position-list').append(data.view);
            
            $('#city-select-' + positionNumber).select2();
            $('#district-select-' + positionNumber).select2();
            $('#status-select-' + positionNumber).select2({
                minimumResultsForSearch: -1
            });
            
            getDistrictFromCity(positionNumber);
            deleteTheaterPosition();
        })
        .fail(function(xhr, status, error) {
            console.log(this.url);
            console.log(xhr.responseText);
            console.log(error);
        });
    });
    
});

/**
* Get district from city
*/
function getDistrictFromCity(i) {
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
    $('.btn-delete').off('click').on('click', function(e) {
        e.preventDefault();

        var deleteNumber = $(this).data('item');
        var id = $(this).data('id');
        
        BootstrapDialog.confirm({
            title: 'Delete a Position Theater',
            message: 'Do you really want to delete selected position theater?',
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

                        })
                        .fail(function(xhr, status, error) {
                            console.log(thisl.url);
                            console.log(error);
                            console.log(xhr.responseText);
                        });
                    }
                }
            }
        });
    });
}