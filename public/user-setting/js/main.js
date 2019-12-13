$(document).ready(function(){
    // main function
    changePassword();
    checkUploadUpdate();
    uploadAvatar();
    subcribe();
    personalTradingDelete();
    realEstateDelete();
    jobSearchingDelete();
    bullboardDelete();
    deleteTown();
    deleteBusiness();
    notification();
    
    $('.datatables').DataTable({
        "order": [[0, 'desc']]
    })
});

// general variable
var clickDel = 0;
// save new password and hidden input change password
function changePassword () {
    // prevent event a tag
    $('#changePW, #hideInput').click(function(event){
        event.preventDefault();
    });
    // click a tag show input
    $('#changePW').on('click', function () {
        $('#ipPass').removeClass('d-none');
        $('#savePW').removeClass('d-none');
    });
    // hide input
    $('#hideInput').on('click', function () {
        $('#ipPass').addClass('d-none');
        $('#savePW').addClass('d-none');
    })
    $('#savePW').on('click', function () {
        var oldPassword = $('input[name=old_password]').val();
        var newPassword = $('input[name=password]').val();
        var passwordConfirm = $('input[name=password_confirm]').val();
        var result = false;
        $.ajax({
            url: base_url + '/account-setting/change-user-password',
            method: 'POST',
            data: {
                old_password: oldPassword,
                password: newPassword,
                password_confirm: passwordConfirm
            },
            async: false
        })
        .done(function (data) {
            console.log(data);
            if(data.result == -1) {
                var err_str = '';
                data.errors.forEach(function(err, index) {
                    err_str += '<i class="fas fa-exclamation-circle"></i> ' + err + '<br/>';
                });
                
                BootstrapDialog.show({
                    'title': 'Update new password',
                    'message': err_str,
                    'type': BootstrapDialog.TYPE_DANGER
                });
            }
            else {
                BootstrapDialog.show({
                    'title': 'Update new password',
                    'message': 'Successfully changed the password!',
                    'type': BootstrapDialog.TYPE_SUCCESS
                });
            }
        })
        .fail (function (xhr, status, error) {
            console.log(this.url);
            console.log(error);
            console.log(xhr.responseText);
            result = false;
        })
        $('input[type=password]').val('');
        $('#ipPass').addClass('d-none');
        $('#savePW').addClass('d-none');
        return result;
    });
}

// update subcribe
function subcribe () {
    $('#subcribe').on('click', function () {
        var result = false;
        var flag = 0;
        $.ajax({
            url: base_url + '/account-setting/update-user-subcribe',
            method: 'POST',
            data: {
                flag: flag,
            },
            async: false
        })
        .done (function (data) {
            console.log(data);
            if (data == '1') {
                $('#subcribe').removeClass('btn-danger').addClass('btn-secondary');
                $('#subcribe').html('<i class="fas fa-envelope mr-2"></i> Unsubcribe POSTE');
            }
            if (data == '0') {
                $('#subcribe').removeClass('btn-secondary').addClass('btn-danger');
                $('#subcribe').html('<i class="far fa-envelope mr-2"></i>Subcribe POSTE');
            }
        })
        .fail (function (xhr, status, error) {
            console.log(this.url);
            console.log(error);
            console.log(xhr.responseText);
            result = false;
        })
        return result;
    })
}

// personal trading delete
function personalTradingDelete () {
    $('.personal').on('click', function () {
        var id = $(this).attr("data-id");
        BootstrapDialog.confirm({
            title: 'Delete Personal Trading',
            message: 'Do you really want to delete selected item? You can not restore after confirm it...',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function(result) {
                if(result) {
                    // var check = true;
                    $.ajax({
                        url: base_url + '/account-setting/delete-personal-trading',
                        method: 'POST',
                        data: {
                            id: id
                        }
                    })
                    .done(function(data) {
                        console.log(data);
                        location.reload();
                    })
                    .fail(function(xhr, status, error) {
                        console.log(this.url);
                        console.log(error);
                        console.log(xhr.responseText);
                    });
                }
            }
        });
    });
}

// real estate delete
function realEstateDelete () {
    $('.realEstate').on('click', function () {
        
        var id = $(this).attr("data-id");
        BootstrapDialog.confirm({
            title: 'Delete Real Estate',
            message: 'Do you really want to delete selected item? You can not restore after confirm it...',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function(result) {
                if(result) {
                    $.ajax({
                        url: base_url + '/account-setting/delete-real-estate',
                        method: 'POST',
                        data: {
                            id: id
                        }
                    })
                    .done(function(data) {
                        console.log(data);
                        location.reload();
                    })
                    .fail(function(xhr, status, error) {
                        console.log(this.url);
                        console.log(error);
                        console.log(xhr.responseText);
                    });
                }
            }
        });
    });
}
// jobSearching delete
function jobSearchingDelete () {
    $('.jobSearching').on('click', function () {
        
        var id = $(this).attr("data-id");
        BootstrapDialog.confirm({
            title: 'Delete Job Searching',
            message: 'Do you really want to delete selected item? You can not restore after confirm it...',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function(result) {
                if(result) {
                    $.ajax({
                        url: base_url + '/account-setting/delete-job-searching',
                        method: 'POST',
                        data: {
                            id: id
                        }
                    })
                    .done(function(data) {
                        console.log(data);
                        location.reload();
                    })
                    .fail(function(xhr, status, error) {
                        console.log(this.url);
                        console.log(error);
                        console.log(xhr.responseText);
                    });
                }
            }
        });
    });
}

// bullboard delete
function bullboardDelete () {
    $('.bullboard').on('click', function () {
        
        var id = $(this).attr("data-id");
        BootstrapDialog.confirm({
            title: 'Delete Bullboard',
            message: 'Do you really want to delete selected item? You can not restore after confirm it...',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function(result) {
                if(result) {
                    $.ajax({
                        url: base_url + '/account-setting/delete-bullboard',
                        method: 'POST',
                        data: {
                            id: id
                        }
                    })
                    .done(function(data) {
                        console.log(data);
                        location.reload();
                    })
                    .fail(function(xhr, status, error) {
                        console.log(this.url);
                        console.log(error);
                        console.log(xhr.responseText);
                    });
                }
            }
        });
    });
}

// Town delete
function deleteTown () {
    $('#table-view').on('click', '.btn-delete-town', function (e) {
        e.preventDefault();
        
        var id = $(this).data("id");
        BootstrapDialog.confirm({
            title: 'Delete Town',
            message: 'Do you really want to delete selected item? <br/>You can not restore after confirm it...',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function (result) {
                clickDel++;
                if (result) {
                    if (clickDel == 1) {
                        $('.btn-danger').addClass('disabled')
                        $.ajax({
                            url: base_url + '/account-setting/town/delete',
                            method: 'POST',
                            data: {
                                id: id
                            }
                        })
                        .done(function (data) {
                            clickDel = 0;
                            $('.btn-danger').removeClass('disabled')
                            if (data.result) {
                                $('#table-view').html(data.view);
                                
                                $('.datatables').DataTable().destroy();
                                
                                loadDataTable();
                                
                                BootstrapDialog.show({
                                    title: 'Delete Town Article',
                                    message: 'Delete a town article Successfully',
                                    type: BootstrapDialog.TYPE_SUCCESS
                                });
                            } else {
                                BootstrapDialog.show({
                                    title: 'Delete Town Article',
                                    message: 'Delete a town article failed...',
                                    type: BootstrapDialog.TYPE_WARNING
                                });
                            }
                            
                        })
                        .fail(function (xhr, status, error) {
                            BootstrapDialog.show({
                                title: 'Delete Town Article',
                                message: 'Delete a town article failed...',
                                type: BootstrapDialog.TYPE_WARNING
                            });
                            
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
// End Town delete

// Business delete
function deleteBusiness () {
    $('#table-view').on('click', '.btn-delete-business', function (e) {
        e.preventDefault();
        
        var id = $(this).attr("data-id");
        
        BootstrapDialog.confirm({
            title: 'Delete Business',
            message: 'Do you really want to delete selected item? <br/>You can not restore after confirm it...',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function(result) {
                if (result) {
                    clickDel++;
                    if (clickDel == 1) {
                        $('.btn-danger').addClass('disabled')
                        $.ajax({
                            url: base_url + '/account-setting/business/delete',
                            method: 'POST',
                            data: {
                                id: id
                            },
                            async: false
                        })
                        .done(function(data) {
                            clickDel = 0;
                            $('.btn-danger').removeClass('disabled')
                            if(data.result) {
                                $('#table-view').html(data.view);
                                
                                $('.business-datatables').DataTable().destroy();
                                
                                loadDataTable();
                                
                                BootstrapDialog.show({
                                    title: 'Delete Business Article',
                                    message: 'Delete a business article Successfully',
                                    type: BootstrapDialog.TYPE_SUCCESS
                                });
                            } else {
                                BootstrapDialog.show({
                                    title: 'Delete Business Article',
                                    message: 'Delete a business article failed...',
                                    type: BootstrapDialog.TYPE_WARNING
                                });
                            }
                        })
                        .fail(function(xhr, status, error) {
                            console.log(this.url);
                            console.log(error);
                            console.log(xhr.responseText);
                            
                            BootstrapDialog.show({
                                title: 'Delete Business Article',
                                message: 'Delete a business article failed...',
                                type: BootstrapDialog.TYPE_WARNING
                            });
                        });
                    }
                }
            }
        });
    });
}

// upload avatar
function uploadAvatar () {
    $('#inputGroupFile02').on('change', function () {
        $('#form_avatar').trigger('submit');
    })
}

function checkUploadUpdate (){
    if ($('#check-upload-update').val() == 1) {
        BootstrapDialog.show({
            'title': 'Notification',
            'message': 'Successfully updated',
            'type': BootstrapDialog.TYPE_SUCCESS
        })
    }
}

// get notification
function notification () {
    
    // mark read all notification
    $('#read-all').on('click', function (e) {
        e.preventDefault();
        $.ajax({
            url: base_url + '/account-setting/notification-read-all',
            method: 'POST'
        })
        .done (function (data) {
            console.log(data);
            if (data == 1) {
                $('.list-group-item').removeClass('noti');
                $('#notiButton').removeClass('new-noti');
            }
            else {
                BootstrapDialog.show({
                    title: 'Warning',
                    message: 'Can not mark all as read!',
                    type: BootstrapDialog.TYPE_DANGER
                })
            }
        })
        .fail(function (xhr, status, error) {
            console.log(this.url);
            console.log(error);
            console.log(xhr.responseText);
            BootstrapDialog.show({
                title: 'Warning',
                message: 'Can not mark all as read!',
                type: BootstrapDialog.TYPE_DANGER
            });
        });
    });
    
    // delete notification
    $('.noti-delete').on('click', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax ({
            url: base_url + '/account-setting/notification-delete',
            method: 'POST',
            data: {
                'id': id
            }
        })
        .done (function (data) {
            console.log(data);
            if (data == 1) {
                $('#noti-li[data-id=' + id + ']').remove();
                location.reload();
            }
            else {
                BootstrapDialog.show({
                    title: 'Warning',
                    message: 'Can not delete this notification!',
                    type: BootstrapDialog.TYPE_DANGER
                })
            }
        })
        .fail (function (xhr, status, err) {
            console.log(xhr);
            console.log(status);
            console.log(err);
        });
    });
    
    // mark as read
    $('.check-seen').on('click', function (e) {
        var id = $(this).data('id');
        $.ajax({
            url: base_url + '/account-setting/notification-update-status',
            method: 'POST',
            data: {
                'id': id
            }
        })
        .done(function (data) {
            console.log(data);
            if (data == 1) {
                location.reload();
            }
            else {
                BootstrapDialog.show({
                    title: 'Warning',
                    message: 'Can not update status for this notification!',
                    type: BootstrapDialog.TYPE_DANGER
                })
            }
        })
        .fail(function (xhr, status, err) {
            console.log(xhr);
            console.log(status);
            console.log(err);
        });
    });
}
