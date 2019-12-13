$(document).ready(function() {
    var showtimeCount = $('.showtime-item').length;

    $('select[name="city_id"]').on('change', function() {
        var cityId = $(this).val();
        var movieId = $('select[name="movie_id"]').val();
        
        if(movieId && movieId > 0) {
            showtimeCount = getShowtimeList(movieId, cityId);
        }
    });
    
    $('#btn-add-showtime').on('click', function(e) {
        e.preventDefault();
        
        var cityId = $('select[name="city_id"]').val();
        
        if(cityId) {
            showtimeCount += 1;
            
            $.ajax({
                url: base_url + '/admin/movie-show-time/add-show-time',
                method: 'GET',
                data: {
                    'showtime_count': showtimeCount
                }
            })
            .done(function(data) {
                if(data.result) {
                    $('#showtime-list').prepend(data.view);
                    
                    setDatetimePicker(showtimeCount);
                    getPositonfromBranch(showtimeCount);
                    deleleteShowTime();
                } else {
                    MyBootstrapShow('Add More Showtime', 'Something was wong...', 'warning');        
                }
            })
            .fail(function(xhr, status, error) {
                console.log(this.url);
                console.log(error);
                console.log(xhr.responseText);
            });
            
        } else {
            MyBootstrapShow('Add More Showtime', 'Please choose City first', 'danger');
        }
    });
});

function setDatetimePicker(i) {
    var current = $('#showtime-item-' + i + ' input.datepicker').val();
    if(current !== '') {
        $('#showtime-item-' + i + ' input.datepicker').datetimepicker({
            format: 'MM-DD-YYYY',
            minDate: moment().startOf('day'),
            useCurrent: false,
            defaultDate: moment(current, 'MM-DD-YYYY')
        });
    } else {
        $('#showtime-item-' + i + ' input.datepicker').datetimepicker({
            format: 'MM-DD-YYYY',
            minDate: moment().startOf('day')
        });
    }
}

function getPositonfromBranch(i) {    
    $('#showtime-item-' + i + ' select[name="branch[]"]').on('change', function() {
        var branchId = $(this).val();
        var cityId = $('select[name="city_id"]').val();
        
        if (cityId) {
            $.ajax({
                url: base_url + '/admin/movie-show-time/get-position',
                method: 'GET',
                data: {
                    'city_id': cityId,
                    'branch_id': branchId
                }
            })
            .done(function(data) {
                $('#showtime-item-' + i + ' select[name="position_ids[]"]').html(data.view);
                $('#showtime-item-' + i + ' select[name="position_ids[]"]').select2('destroy').select2();
            })
            .fail(function(xhr, status, error) {
                console.log(this.url);
                console.log(error);
                console.log(xhr.responseText);
            });
        } else {
            MyBootstrapShow('Add More Showtime', 'Please choose City first', 'danger');
        }
    });
}

function getShowtimeList(movieId, cityId) {
    $.ajax({
        url: base_url + '/admin/movie-show-time/get-showtime-list',
        method: 'GET',
        data: {
            'city_id': cityId,
            'movie_id': movieId
        },
        async: false
    })
    .done(function (data) {        
        $('#showtime-list').html(data.view);
        
        var showtimeCount = $('.showtime-item').length;
        for (var i = 0; i < showtimeCount; i++) {
            setDatetimePicker(i + 1);
            getPositonfromBranch(i + 1);
            deleleteShowTime();
        }
    })
    .fail(function (xhr, status, error) {
        console.log(this.url);
        console.log(error);
        console.log(xhr.responseText);
    });

    return $('.showtime-item').length;
}

function deleleteShowTime() {
    $('.delete-showtime').off('click').on('click', function() {
        var showtimeCount = $(this).data('showtime-count');
        var showtimeId = $('#showtime-item-' + showtimeCount + ' input[name="showtime_ids[]"]').val();
        var btn = $(this);

        BootstrapDialog.confirm({
            title: 'Delete a Showtime',
            message: 'Do you really want to delete selected Showtime?',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function (result) {
                if(showtimeId != 0) {
                    $.ajax({
                        url: base_url + '/admin/movie-show-time/delete',
                        method: 'POST',
                        data: {
                            'id': showtimeId,
                        }
                    })
                    .done(function(data) {
                        if(data.result) {
                            MyBootstrapShow('Delete a Showtime', 'Delete Showtime Successfully', 'success');
                        } else {
                            MyBootstrapShow('Delete a Showtime', data.error, 'warning');
                        }
                    })
                    .fail(function(xhr, status, error) {
                        console.log(this.url);
                        console.log(error);
                        console.log(xhr.responseText);
                    });
                }
                $('#showtime-item-' + showtimeCount).remove();
            }
        });
    });
}