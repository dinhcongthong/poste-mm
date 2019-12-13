$(document).ready(function() {
    var avatar_url = base_url + '/images/poste/default-town-thumb.png';
    if ($('input[name="avatar_url"]').val() !== '') {
        avatar_url = $('input[name="avatar_url"]').val();
    }
    $("#avatar-2").fileinput({
        theme: 'fas',
        overwriteInitial: true,
        maxFileSize: 2049,
        showClose: false,
        showCaption: false,
        showBrowse: false,
        browseOnZoneClick: true,
        removeLabel: '',
        // removeIcon: '<i class="fas fa-times"></i>',
        removeTitle: 'Cancel or reset changes',
        elErrorContainer: '#kv-avatar-errors-2',
        msgErrorClass: 'alert alert-block alert-danger',
        defaultPreviewContent: '<img src="' + avatar_url + '" alt="Your Avatar" class="img-fluid mb-4"><h6 class="text-muted">Click to select</h6>',
        layoutTemplates: { main2: '{preview} ' + ' {remove} {browse}' },
        allowedFileExtensions: ["jpg", "png", "gif"]
    });

    $('.time-picker').datetimepicker({
        format: 'HH:mm'
    });

    $('.datepicker').datetimepicker({
        format: 'MM-DD-YYYY'
    });

    $('.select2-no-search').select2({
        minimumResultsForSearch: -1
    });

    $('#town-tags-select').select2({
        placeholder: 'Please choose tag... (Option)'
    });

    // set datetimepicker status when open edit page
    $.each($('select[name="status_working_time[]"]'), function() {
        var status_val = $(this).val();
        var status_count = $(this).data('count');

        if (status_val == 1) {
            $('.time-picker[data-count="' + status_count + '"]').datetimepicker('enable');
        } else {
            $('.time-picker[data-count="' + status_count + '"]').datetimepicker('disable');
        }
    });

    changeWorkingTimeStatus();


    // Laundry
    if ($('select[name="sl_laundry"]').length) {
        getNoteFeatures('sl_laundry', 'ip_laundry');
    }
    // Breakfast
    if ($('select[name="sl_breakfast"]').length) {
        getNoteFeatures('sl_breakfast', 'ip_breakfast');
    }
    // Wifi
    if ($('select[name="sl_wifi"]').length) {
        getNoteFeatures('sl_wifi', 'ip_wifi');
    }
    // Parking
    if ($('select[name="sl_parking"]').length) {
        getNoteFeatures('sl_parking', 'ip_parking');
    }
    // Private room
    if ($('select[name="sl_private_room"]').length) {
        getNoteSelectFeatures('sl_private_room', 'sl_private_room_content[]');
    }
    // Smoking room
    if ($('select[name="sl_smoking"]').length) {
        getNoteFeatures('sl_smoking', 'ip_smoking');
    }
    // Service Tax
    if ($('select[name="sl_service_tax"]').length) {
        getNoteSelectFeatures('sl_service_tax', 'sl_service_tax_content');
    }


    // Menu Form
    addFoodSection();
    addFood();
    addPDFFile();
    addGallery();
    // addRegularclose();

    deleteMenuSection();
    deleteFood();
    deletePDFFile();
    deleteGalleryImage();
    // deleteRegularClose();

    loadPreviewMenu();
});

function addFoodSection() {
    $('#add-food-section').on('click', function () {
        var count = $(this).data('count') + 1;
        var imgURL = base_url + '/images/poste/blank.svg';

        var html = '<form class="menu-form" data-count="' + count + '" action="#" id="menu-form-' + count + '">';
        html += '<input type="hidden" value="0" name="menu_section_id">';
        html += '<div class="card mb-4" id="menu-section-' + count + '">';
        html += '   <div class="card-header">';
        html += '       <input type="text" class="form-control" name="food_section" placeholder="グループ名（Group Name）">';
        html += '   </div>';
        html += '   <div class="card-body">';
        html += '       <div id="menu-grid-' + count + '" class="d-grid x1 x2-lg g-2 g-lg-3 mb-3">';
        html += '           <div class="food-item d-flex flex-wrap align-items-end" id="food-item-1">';
        html += '               <input type="hidden" name="food_ids[]" value="0">';
        html += '               <div class="row no-gutters">';
        html += '               <div class="col-3 pr-2">';
        html += '                   <div class="media-wrapper-1x1">';
        html += '                       <img class="img-cover" id="food-image-1" src="' + imgURL + '" alt="food image">';
        html += '                   </div>';
        html += '                   <div class="food-image-browse">';
        html += '                       <label class="w-100 text-center border m-0 bg-grey">Browse</label>';
        html += '                       <input type="file" name="food_image[]" data-count="1" data-section="' + count + '" class="ip-food-image">';
        html += '                   </div>';
        html += '               </div>';
        html += '               <div class="col-9 d-flex flex-wrap text-left">';
        html += '                   <input type="text" name="food_name[]" class="form-control" placeholder="商品名（Name">';
        html += '                   <input type="text" name="food_price[]" class="form-control" placeholder="値段（Price">';
        html += '                   <a href="#" class="ml-auto text-danger delete-food" data-id="0" data-section="' + count + '" data-count="1">削除（Delete）</a>';
        html += '               </div>';
        html += '               </div>';
        html += '           </div>';
        html += '       </div>';
        html += '       <button type="button" class="btn btn-primary add-food" data-count="' + count + '">Add Food Item</button>';
        html += '   </div>';
        html += '   <div class="card-footer">';
        html += '       <button class="btn btn-danger float-right delete-menu-section" data-id="0" data-section="' + count + '">削除（Delete）</button>';
        html += '   </div>';
        html += '</div>';
        html += '</form>';

        $('#menu-list-content').append(html);
        $(this).attr('data-count', count);
        $(this).data('count', count);

        addFood();
        loadPreviewMenu();
        deleteFood();
        deleteMenuSection();
    });
}
function addFood() {
    $('.add-food').off('click').on('click', function () {
        var count = $(this).data('count');
        var foodCount = $('#menu-grid-' + count + ' .food-item').length + 1;

        var html = '';
        html += '<div class="food-item d-flex flex-wrap align-items-end" id="food-item-' + foodCount + '">';
        html += '   <input type="hidden" name="food_ids[]" value="0">';
        html += '   <div class="row no-gutters">';
        html += '   <div class="col-3 pr-2">';
        html += '       <div class="media-wrapper-1x1">';
        html += '           <img class="img-cover"  id="food-image-' + foodCount + '" src="' + base_url + '/images/poste/blank.svg' + '" alt="food image">';
        html += '       </div>';
        html += '       <div class="food-image-browse">';
        html += '           <label class="w-100 text-center border m-0 bg-grey">Browse</label>';
        html += '           <input type="file" name="food_image[]" data-count="' + foodCount + '" data-section="' + count + '" class="ip-food-image">';
        html += '       </div>';
        html += '   </div>';
        html += '   <div class="col-9 d-flex flex-wrap text-left">';
        html += '       <input type="text" name="food_name[]" class="form-control" placeholder="商品名（Name">';
        html += '       <input type="text" name="food_price[]" class="form-control" placeholder="値段（Price">';
        html += '       <a href="#" class="ml-auto text-danger delete-food" data-id="0" data-section="' + count + '" data-count="' + foodCount + '">削除（Delete）</a>'
        html += '   </div>';
        html += '   </div>'
        html += ' </div>';

        $('#menu-grid-' + count).append(html);

        loadPreviewMenu();
        deleteFood();
    });
}
function addPDFFile() {

    $('.add-pdf-menu').on('change', function (e) {

        $('.error-area').remove();

        var input = $(this);

        var town_id = $('input[name="town_id"]').val();

        for (var i = 0; i < e.target.files.length; i++) {
            var formData = new FormData();
            formData.append('file', e.target.files[i]);
            formData.append('town_id', town_id);

            $.ajax({
                url: base_url + '/town/upload-pdf-menu',
                method: 'POST',
                data: formData,
                processData: false,
                cache: false,
                contentType: false
            })
            .done(function (data) {
                console.log(data);
                if (data.result) {
                    var html = '';
                    html += ' <div class="pdf-item mb-4" id="pdf-item-' + data.id + '">';
                    html += '   <iframe src="' + data.url + '" width="100%" height="500"></iframe>'
                    html += '   <a href="#" class="text-danger delete-pdf" data-id="' + data.id + '">Delete File</a>'
                    html += '</div>'
                    $('#pdf-list').append(html);

                    $('input[name="pdf_ids"]').val(data.id);

                    $('#add-pdf-area > div').remove();

                    deletePDFFile();
                } else {
                    alert('Have errors, please check');
                    return false;
                }
            })
            .fail(function (xhr, status, error) {
                console.log(this.data);
                if(xhr.status == 422) {
                    var response = JSON.parse(xhr.responseText);
                    var errors = response.errors;

                    var html =  '<div class="alert alert-danger error-area rounded-0">';
                    html +=     '   <ul class="mb-0 w-100">';
                    $.each(errors, function (key, value) {
                        html += '       <li>' + value + '</li>';
                    });
                    html +=     '   </ul>';
                    html +=     '</div>';

                    $('#pdf-list').prepend(html);
                    $('html').animate({
                        scrollTop: eval($('#pdf-list').offset().top - 250)
                    }, 300);
                    $('#pdf-menu-tab').tab('show');
                }
                console.log(this.url);
                console.log(error);
                console.log(xhr.responseText);
            });
        }
    });
}
function addGallery() {
    $('.add-image-input').on('change', function (e) {

        $('.error-area').remove();

        $('.gallery-errors').fadeOut();
        var input = $(this);

        var type = $(this).data('type');
        var town_id = $('input[name="town_id"]').val();

        for (var i = 0; i < e.target.files.length; i++) {
            var formData = new FormData();
            formData.append('image', e.target.files[i]);
            formData.append('type', type);
            formData.append('town_id', town_id);

            $.ajax({
                url: base_url + '/town/add-image-gallery',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                async: false
            })
            .done(function (data) {
                if (data.result) {
                    switch (type) {
                        case 1: {
                            $.each(data.file_urls, function (index, value) {
                                var html = '';
                                html += '<div id="gallery-item-'+data.gallery_ids[index]+'" class="gallery-item position-relative">';
                                html += '   <div class="media-wrapper-1x1">';
                                html += '       <a href="#" target="_blank">';
                                html += '           <img class="img-cover" src="' + value + '">';
                                html += '       </a>';
                                html += '   </div>'
                                html += '   <button type="button" class="btn btn-danger position-absolute delete-gallery" data-id="' + data.gallery_ids[index] + '" data-section="1" style="bottom: 10px; right: 10px;">Delete</button>'
                                html += '</div>'

                                $('#space-list').prepend(html);
                            });
                            if ($('input[name="space_list"]').val() === '') {
                                $('input[name="space_list"]').val(data.gallery_ids);
                            } else {
                                $('input[name="space_list"]').val($('input[name="space_list"]').val() + ',' + data.gallery_ids);
                            }
                            $('#space-count').text($('#space-list .gallery-item').length);
                            break;
                        }
                        case 2: {
                            $.each(data.file_urls, function (index, value) {
                                var html = '';
                                html += '<div id="gallery-item-'+data.gallery_ids[index]+'" class="gallery-item  position-relative">';
                                html += '   <div class="media-wrapper-1x1">';
                                html += '       <a href="#" target="_blank">';
                                html += '           <img class="img-cover" src="' + value + '">';
                                html += '       </a>';
                                html += '   </div>';
                                html += '   <button type="button" class="btn btn-danger position-absolute delete-gallery" data-id="' + data.gallery_ids[index] + '" data-section="2" style="bottom: 10px; right: 10px;">Delete</button>';
                                html += '</div>';

                                $('#food-list').prepend(html);
                            });
                            if ($('input[name="food_list"]').val() === '') {
                                $('input[name="food_list"]').val(data.gallery_ids);
                            } else {
                                $('input[name="food_list"]').val($('input[name="food_list"]').val() + ',' + data.gallery_ids);
                            }
                            $('#food-count').text($('#food-list .gallery-item').length);
                            break;
                        }
                        case 3: {
                            $.each(data.file_urls, function (index, value) {
                                var html = '';
                                html += '<div id="gallery-item-'+data.gallery_ids[index]+'" class="gallery-item  position-relative">';
                                html += '   <div class="media-wrapper-1x1">';
                                html += '       <a href="#" target="_blank">';
                                html += '           <img class="img-cover" src="' + value + '">';
                                html += '       </a>';
                                html += '   </div>';
                                html += '   <button type="button" class="btn btn-danger position-absolute delete-gallery" data-id="' + data.gallery_ids[index] + '" data-section="3" style="bottom: 10px; right: 10px;">Delete</button>';
                                html += '</div>';

                                $('#menu-gallery-list').prepend(html);
                            });
                            if ($('input[name="menu_list"]').val() === '') {
                                $('input[name="menu_list"]').val(data.gallery_ids);
                            } else {
                                $('input[name="menu_list"]').val($('input[name="menu_list"]').val() + ',' + data.gallery_ids);
                            }
                            $('#menu-count').text($('#menu-list .gallery-item').length);
                            break;
                        }
                        case 4: {
                            $.each(data.file_urls, function (index, value) {
                                var html = '';
                                html += '<div id="gallery-item-'+data.gallery_ids[index]+'" class="gallery-item  position-relative">';
                                html += '   <div class="media-wrapper-1x1">'
                                html += '       <a href="#" target="_blank">'
                                html += '           <img class="img-cover" src="' + value + '">';
                                html += '       </a>'
                                html += '   </div>'
                                html += '   <button type="button" class="btn btn-danger position-absolute delete-gallery" data-id="' + data.gallery_ids[index] + '" data-section="4" style="bottom: 10px; right: 10px;">Delete</button>'
                                html += '</div>'

                                $('#general-list').prepend(html);
                            });
                            if ($('input[name="general_list"]').val() === '') {
                                $('input[name="general_list"]').val(data.gallery_ids);
                            } else {
                                $('input[name="general_list"]').val($('input[name="general_list"]').val() + ',' + data.gallery_ids);
                            }
                            $('#general-count').text($('#general-list .gallery-item').length);
                            break;
                        }
                    }
                }
                if($('.gallery-item').length < 100) {
                    $('.btn-add-area').removeClass('d-none');
                } else {
                    $('input.add-image-input').remove();
                    $('.btn-add-area').addClass('d-none');
                }
                deleteGalleryImage();
            })
            .fail(function (xhr, status, error) {
                console.log(error);
                console.log('galerry error');
                if (xhr.status == 422) {
                    var response = JSON.parse(xhr.responseText);
                    var errors = response.errors;

                    var html = '';
                    html += '<div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3 error-area">';
                    html += '   <div class="alert alert-danger">';
                    html += '       <ul class="mb-0 w-100">';
                    $.each(errors, function (key, value) {
                        $.each(value, function(key_err, err) {
                            html += '       <li>' + err + '</li>';
                        });
                    });
                    html += '       </ul>';
                    html += '   </div>';
                    html += '</div>';

                    $('#gallery-errors').html(html).removeClass('d-none').fadeIn();
                } else {
                    console.log(this.url);
                    console.log(error);
                    console.log(xhr.responseText);
                }
                return;
            });

        }
        input.val('');
    });
}

function addRegularclose() {
    $('#add-regular-close').on('click', function (e) {
        e.preventDefault();

        var count = $(this).data('count');
        count++;

        var html = '<div class="regular-close-item" data-count="' + count + '">';
        html += '       <div class="row" >';
        html += '           <input type="hidden" value="0" name="id[]">';
        html += '           <div class="col-12 col-md-3">';
        html += '               <input class="form-control datepicker" name="start_date[]" value="" placeholder="Start Date" required>';
        html += '           </div>';
        html += '           <div class="col-12 col-md-3">';
        html += '               <input class="form-control datepicker" name="end_date[]" value="" placeholder="End Date" required>';
        html += '           </div>';
        html += '           <div class="col-12 col-md-5">';
        html += '               <input class="form-control" name="note[]" value="" placeholder="Note">';
        html += '           </div>';
        html += '           <div class="col-12 col-md">';
        html += '               <button class="btn btn-danger delete-regular" title="Remove" type="button" data-count="' + count + '">';
        html += '                   <i class="fas fa-times-circle"></i>';
        html += '               </button>';
        html += '           </div>';
        html += '       </div>';
        html += '   </div>';

        console.log(count);

        $(this).data('count', count);

        $('#regular-close-section').append(html);

        $('.regular-close-item[data-count="'+count+'"] .datepicker').datetimepicker({
            format: 'MM-DD-YYYY'
        });

        deleteRegularClose();
    });
}


function deleteMenuSection() {
    $('.delete-menu-section').off('click').on('click', function (e) {
        e.preventDefault();

        var id = $(this).data('id');
        var section = $(this).data('section');

        BootstrapDialog.confirm({
            title: 'Delete Food/Product Section',
            message: 'Do you really want to delete selected food/product section?',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function (result) {
                if (result) {
                    if (id != 0) {
                        $.ajax({
                            url: base_url + '/town/delete-menu',
                            method: 'POST',
                            data: {
                                'id': id,
                            }
                        })
                        .done(function (data) {

                        })
                        .fail(function (xhr, status, error) {
                            console.log(this.url);
                            console.log(error);
                            console.log(xhr.responseText);
                        });
                    }

                    $('#menu-form-' + section).remove();
                }
            }
        })
    });
}
function deleteFood() {
    $('.delete-food').off('click').on('click', function (e) {
        e.preventDefault();

        var id = $(this).data('id');
        var section = $(this).data('section');
        var count = $(this).data('count');

        BootstrapDialog.confirm({
            title: 'Delete Food/Product',
            message: 'Do you really want to delete selected food/product?',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function (result) {
                if (result) {
                    if (id != 0) {
                        $.ajax({
                            url: base_url + '/town/delete-food',
                            method: 'POST',
                            data: {
                                'id': id,
                            }
                        })
                        .done(function (data) {

                        })
                        .fail(function (xhr, status, error) {
                            console.log(this.url);
                            console.log(error);
                            console.log(xhr.responseText);
                        });
                    }

                    $('#menu-grid-' + section + ' #food-item-' + count).remove();
                }
            }
        });
    });
}
function deletePDFFile() {
    $('.delete-pdf').off('click').on('click', function (e) {
        $('.error-area').remove();

        e.preventDefault();
        var id = $(this).data('id');

        BootstrapDialog.confirm({
            title: 'Delete an File',
            message: 'Do you really want to delete the Selected PDF',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function (result) {
                if (result) {

                    $.ajax({
                        url: base_url + '/town/delete-pdf',
                        data: {
                            'id': id
                        },
                        method: 'POST'
                    })
                    .done(function (data) {
                        console.log(data);
                        if (data.result) {
                            $('#pdf-item-' + id).remove();

                            var html =      '<div class="w-100 text-center">';
                            html +=         '   <label for="pdf-upload" class="custom-input-file">';
                            html +=         '       Add PDF File';
                            html +=         '   </label>';
                            html +=         '   <input id="pdf-upload" type="file" name="add_pdf_menu" class="add-pdf-menu">';
                            html +=         '   <input type="hidden" name="pdf_ids" value="">';
                            html +=         '</div>';

                            $('#add-pdf-area').html(html);
                            addPDFFile();

                            BootstrapDialog.show({
                                title: 'Delete PDF File',
                                message: 'Delete PDF File Success',
                                type: BootstrapDialog.TYPE_SUCCESS
                            });
                        } else {
                            BootstrapDialog.show({
                                title: 'Delete PDF File',
                                message: 'Delete PDF FIle Fail',
                                type: BootstrapDialog.TYPE_WARNING
                            });
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
function deleteGalleryImage() {
    $('.delete-gallery').off('click').on('click', function () {
        $('.error-area').remove();

        var id = $(this).data('id');
        var section = $(this).data('section');

        BootstrapDialog.confirm({
            title: 'Delete Image Gallery',
            message: 'Do you really want to delete image gallery you choose?',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function (result) {
                if (result) {
                    $.ajax({
                        url: base_url + '/town/delete-gallery',
                        method: 'POST',
                        data: {
                            'id': id,
                        }
                    })
                    .done(function (data) {
                        if (data.result) {
                            $('#gallery-item-' + id).remove();

                            switch(section) {
                                case 1: {
                                    $('#space-count').text($('#space-list .gallery-item').length);
                                    break;
                                }
                                case 2: {
                                    $('#food-count').text($('#food-list .gallery-item').length);
                                    break;
                                }
                                case 3: {
                                    $('#menu-count').text($('#menu-list .gallery-item').length);
                                    break;
                                }
                                case 4: {
                                    $('#general-count').text($('#general-list .gallery-item').length);
                                    break;
                                }
                            }
                        }

                        if($('.gallery-item').length < 100) {
                            $('.btn-add-area').removeClass('d-none');

                            if($('input.add-image-input').length === 0) {
                                $('#btn-add-area-space').append('<input id="space-upload" type="file" name="add_image_space[]" class="add-image-input" data-type="1" multiple>');
                                $('#btn-add-area-food').append('<input id="food-upload" type="file" name="add_image_space[]" class="add-image-input" data-type="2" multiple>');
                                $('#btn-add-area-menu').append('<input id="menu-upload" type="file" name="add_image_space[]" class="add-image-input" data-type="3" multiple>');
                                $('#btn-add-area-general').append('<input id="general-upload" type="file" name="add_image_space[]" class="add-image-input" data-type="4" multiple>');

                                addGallery();
                            }
                        } else {
                            $('input.add-image-input').remove();
                            $('.btn-add-area').addClass('d-none');
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
//  function deleteRegularClose() {
// $('.delete-regular').off('click').on('click', function(e) {
// e.preventDefault();
//
// var count = $(this).data('count');
//
// var id = $('.regular-close-item[data-count="' + count + '"] input[name="id[]"]').val();
// var result = false;
//
// if(id != 0) {
// $.ajax({
// url: base_url + '/town/delete-regular-time',
// data: {
// 'id': id
// },
// method: 'POST',
// async: false
// })
// .done(function(data) {
// if(data.result) {
// result = true;
// } else {
// result = false;
// }
// })
// .fail(function(xhr, status, error) {
// console.log(this.url);
// console.log(error);
// console.log(xhr.responseText);
// });
// }
// if(result) {
// $('.regular-close-item[data-count="' + count + '"]').remove();
// } else {
// BootstrapDialog.show({
// title: 'Delete Regular Close',
// message: 'Remove Closing Date Fail',
// type: BootstrapDialog.TYPE_DANGER
// });
// }
// });
// }


function changeWorkingTimeStatus() {
    $('select[name="status_working_time[]"]').on('change', function() {
        var status_val = $(this).val();
        var status_count = $(this).data('count');

        console.log(status_val);

        if(status_val == 1) {
            console.log('1');
            $('.time-picker[data-count="' + status_count + '"]').datetimepicker('enable');
        } else {
            console.log('2');
            $('.time-picker[data-count="' + status_count + '"]').datetimepicker('disable');
        }
    });
}

/* Helper Functions */
function loadPreviewMenu() {
    $('.ip-food-image').off('change').on('change', function (e) {
        var count = $(this).data('count');
        var section = $(this).data('section');

        var file = e.target.files[0];
        var extension = file.name.substr((file.name.lastIndexOf('.') + 1)).toLowerCase();
        var size = file.size;

        if (extension != 'jpg' && extension != 'jpeg' && extension != 'png') {
            alert('Food Image Extension is wrong');
            $(this).val('');
            return
        }
        if (size > 2100000) {
            alert('Size too large. Please compress image or choose another image...');
            $(this).val('');
            return
        }
        readURL(this, '#menu-grid-' + section + ' #food-image-' + count);
    })
}

function getNoteFeatures(select_name, input_name) {
    var valu = $('select[name="' + select_name + '"]').val();
    if (valu == 1) {
        $('input[name="' + input_name + '"]').removeClass('d-none').addClass('d-block');
    } else {
        $('input[name="' + input_name + '"]').removeClass('d-block').addClass('d-none');
    }
    $('select[name="' + select_name + '"]').on('change', function () {
        var valu = $(this).val();
        if (valu == 1) {
            $('input[name="' + input_name + '"]').removeClass('d-none').addClass('d-block');
        } else {
            $('input[name="' + input_name + '"]').removeClass('d-block').addClass('d-none');
        }
    })
}

function getNoteSelectFeatures(select_name, input_name) {
    var valu = $('select[name="' + select_name + '"]').val();
    if (valu == 1) {
        $('select[name="' + input_name + '"]').removeClass('d-none').addClass('d-block');
    } else {
        $('select[name="' + input_name + '"]').removeClass('d-block').addClass('d-none');
    }
    $('select[name="' + select_name + '"]').on('change', function () {
        var valu = $(this).val();
        if (valu == 1) {
            $('select[name="' + input_name + '"]').removeClass('d-none').addClass('d-block');
        } else {
            $('select[name="' + input_name + '"]').removeClass('d-block').addClass('d-none');
        }
    })
}

function readURL(input, preview) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(preview).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
/* End Helper Functions */
