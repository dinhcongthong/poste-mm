$(document).ready(function() {

    if($('.select2-no-search').length) {

        $('.select2-no-search').select2({
            minimumResultsForSearch: -1
        });
    }

    if($('.select2').length) {
        $('.select2').select2({
            multiple: true,
        });
    }

    $('input[name="avatar"]').on('change', function() {
        previewImage(this);
    });

    addImage();

    addPDFFile();

    addMoreService();

    addRelatedBusiness();

    addMapMore();

    changeImageMap();

    loadImagePrimaryAddress();

    deleteMap();
    deleteRelate();
    deletePDFFile();
    deleteGalleryImage();
    deleteService();

    catchSubmitForm();
});

function addImage() {
    $('input[name="add_image[]"]').on('change', function(e) {

        for(var i = 0; i < e.target.files.length; i++) {
            var formData = new FormData();
            formData.append('image_file', e.target.files[i]);

            $.ajax({
                url: base_url + '/business/add-gallery-image',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                async: false
            })
            .done(function(data) {
                if(data.result) {
                    if($('#gallery-nothing').length) {
                        $('#gallery-nothing').remove();
                    }

                    var html =  '<div id="gallery-item-'+data.gallery_id+'" class="gallery-item position-relative">';
                    html +=     '   <input type="hidden" name="gallery_ids[]" value="' + data.gallery_id + '">';
                    html +=     '   <div class="media-wrapper-1x1">';
                    html +=     '       <a href="'+data.gallery_url+'" target="_blank">';
                    html +=     '           <img class="img-cover" src="'+data.gallery_url+'">';
                    html +=     '       </a>';
                    html +=     '   </div>';
                    html +=     '   <button type="button" class="btn btn-danger position-absolute delete-gallery"  style="bottom: 10px; right: 10px;" data-id="'+data.gallery_id+'">Delete</button>';
                    html +=     '</div>';

                    $('#gallery-list').append(html);

                    if($('.gallery-item').length < 100) {
                        $('#btn-add-gallery-area').removeClass('d-none');
                    } else {
                        $('input.add-image-input').remove();
                        $('#btn-add-gallery-area').addClass('d-none');
                    }

                    deleteGalleryImage();
                } else {
                    var html =  '<div class="alert alert-danger mb-3">'
                    html +=     '   <p class="text-center m-0"> ' + data.error + '</p>';
                    html +=     '</div>';

                    $('#gallery-error-show').html(html);
                }
            })
            .fail(function(xhr, status, error) {
                if(xhr.status == 422) {
                    var response = JSON.parse(xhr.responseText);
                    var errors = response.errors;

                    var html = '';
                    html += '   <div class="alert alert-danger mb-3">';
                    html += '       <ul class="mb-0 w-100">';
                    $.each(errors, function (key, value) {
                        html += '       <li>' + value + '</li>';
                    });
                    html += '       </ul>';
                    html += '   </div>';
                    $('#gallery-error-show').html(html);
                } else {
                    console.log(this.url);
                    console.log(error);
                    console.log(xhr.responseText);

                    var html =  '<div class="alert alert-danger mb-3">'
                    html +=     '   <p class="text-center m-0"> ' + error + '</p>';
                    html +=     '</div>';

                    $('#gallery-error-show').html(html);
                }
            });
        }
    });
}

function addPDFFile() {
    if($('#pdf-list .pdf-item').length >= 1) {
        $('#company-pdf .custom-input-file').css('display', 'none');
    }

    $('input[name="add_pdf"]').on('change', function (e) {
        var input = $(this);
        if(e.target.files.length > 1) {
            $('#pdf-error-show').addClass('text-center').text('Please choose only 1 PDF file');
        }

        var formData = new FormData();
        formData.append('file', e.target.files[0]);

        $.ajax({
            url: base_url + '/business/upload-pdf-menu',
            method: 'POST',
            data: formData,
            processData: false,
            cache: false,
            contentType: false
        })
        .done(function (data) {
            if (data.result) {

                if($('#pdf-nothing').length) {
                    $('#pdf-nothing').remove();
                }

                $('#company-pdf .custom-input-file').removeClass('d-inline-block').addClass('d-none');

                var html = '';
                html += ' <div class="pdf-item mb-4">';
                html += '   <iframe src="' + data.url + '" width="100%" height="500"></iframe>'
                html += '</div>'
                $('#pdf-list').append(html);
                $('input[name="pdf_url"]').val(data.url);

                $('#company-pdf a').addClass('d-inline-block').removeClass('d-none');

                deletePDFFile();
            } else {
                alert('Have errors, please check');
                return false;
            }
        })
        .fail(function (xhr, status, error) {
            console.log(this.url);
            console.log(error);
            console.log(xhr.responseText);
            if(xhr.status == 422) {
                var response = JSON.parse(xhr.responseText);
                var errors = response.errors;

                var html = '';
                html += '   <div class="alert alert-danger mb-3">';
                html += '       <ul class="mb-0 w-100">';
                $.each(errors, function (key, value) {
                    html += '       <li>' + value + '</li>';
                });
                html += '       </ul>';
                html += '   </div>';
                var html = '';
                html += '   <div class="alert alert-danger mb-3 w-100">';
                html += '       <ul class="mb-0">';
                $.each(errors, function (key, value) {
                    html += '       <li>' + value + '</li>';
                });
                html += '       </ul>';
                html += '   </div>';
                $('.pdf_error').fadeIn();
                $('#pdf_error').html(html).removeClass('d-none').fadeIn();
            } else {
                console.log(this.url);
                console.log(error);
                console.log(xhr.responseText);
            }
        });
    });
}

function addMoreService() {
    $('#btn-add-service').on('click', function() {
        var count = $(this).data('count');
        count++;

        var html =  '<div class="service-item" id="service-item-' + count + '">'
        html +=     '   <form class="business-service-form">';
        html +=     '       <input type="hidden" name="service_id" value="0">';
        html +=     '       <input placeholder="Service Name" class="form-control mb-3" name="service_name">';
        html +=     '       <textarea class="form-control" placeholder="Service Description" name="service_description"></textarea>';
        html +=     '       <br/>';
        html +=     '       <a href="#" class="float-right text-danger btn-delete-service" data-count="' + count + '">Delete</a>';
        html +=     '   </form>';
        html +=     '</div>';

        $(this).data('count', count);

        $('#service-list').append(html);

        if($('.service-item').length > 0) {
            $('#service-nothing').remove();
        }

        deleteService();
        catchSubmitForm();
    });
}

function addRelatedBusiness() {
    $('#add-related-more').on('click', function() {
        var count = $(this).data('count');
        count++;

        var html =      '<div class="col-12 col-md-6 mb-4 related-item" id="related-item-' + count + '">';
        html +=         '   <form class="related-form">'
        html +=         '       <div class="card">';
        html +=         '           <input type="hidden" name="related_id" value="0">';
        html +=         '           <div class="card-header">';
        html +=         '               <input type="text" placeholder="Business Name" name="related_name" class="form-control">';
        html +=         '           </div>';
        html +=         '           <div class="card-body">';
        html +=         '               <div>';
        html +=         '                   <label class="label-form-control">Address</label>';
        html +=         '                   <input type="text" class="form-control mb-2" name="related_address">';
        html +=         '               </div>';
        html +=         '               <div>';
        html +=         '                   <label class="label-form-control">Phone</label>';
        html +=         '                   <input type="text" class="form-control mb-2" name="related_phone">';
        html +=         '               </div>';
        html +=         '               <div>';
        html +=         '                   <label class="label-form-control">Email</label>';
        html +=         '                   <input type="text" class="form-control mb-2" name="related_email">';
        html +=         '               </div>';
        html +=         '               <div>';
        html +=         '                   <label class="label-form-control">Website</label>';
        html +=         '                   <input type="text" class="form-control" name="related_website">';
        html +=         '               </div>';
        html +=         '           </div>';
        html +=         '           <div class="card-footer">';
        html +=         '               <button class="btn btn-danger float-right btn-delete-related" type="button" data-count="' + count + '">Delete</button>';
        html +=         '           </div>';
        html +=         '       </div>';
        html +=         '   </form>';
        html +=         '</div>';

        $('#related-list').append(html);
        $(this).data('count', count);

        if($('.related-item').length > 0) {
            $('#relate-nothing').remove();
        }

        deleteRelate();
        catchSubmitForm();
    });
}

function addMapMore() {
    $('#add-map-more').on('click', function() {
        var count = $(this).data('count');
        count++;

        var html =  '<div class="col-12 col-md-6 mb-4" id="map-more-' + count + '">';
        html +=     '    <form class="map-more-form" data-count="' + count + '">';
        html +=     '       <input type="hidden" name="branch_id" value="0">';
        html +=     '       <div class="card">';
        html +=     '           <div class="card-body">';
        html +=     '               <input class="form-control mb-2" name="address" placeholder="Address">';
        html +=     '               <input class="form-control mb-2" name="map" placeholder="Google Map Embeded Code">';
        html +=     '               <textarea placeholder="Route Guide" rows="5" name="route_guide" class="form-control mb-4"></textarea>';
        html +=     '               <p class="font-weight-bold">Image</p>';
        html +=     '               <div class="w-100 text-center mb-2 img-route-guide-preview">';
        html +=     '                   <img class="img-responsive mh-100 m-auto img-map-preview" alt="Other map Image" src="' + base_url + '/images/poste/no-image-6x4.png">';
        html +=     '               </div>';
        html +=     '               <input type="file" name="image_route_guide" data-count="' + count + '">';
        html +=     '           </div>';
        html +=     '           <div class="card-footer">';
        html +=     '               <a href="#" class="text-danger float-right btn-delete-map" data-count="' + count + '">Delete</a>';
        html +=     '           </div>';
        html +=     '       </div>';
        html +=     '   </form>';
        html +=     '</div>';

        $('#map-list').append(html);

        changeImageMap();
        deleteMap();
        catchSubmitForm();

        $(this).data('count', count);
    });
}

function changeImageMap() {
    $('input[name="image_route_guide"]').off('change').on('change', function() {
        var count = $(this).data('count');

        img_route_preview(this, count);
    });
}

function deleteMap() {
    $('.btn-delete-map').off('click').on('click', function(e) {
        e.preventDefault();

        var count = $(this).data('count');
        var id = $('.map-more-form[data-count="' + count + '"] input[name="branch_id"]').val();


        BootstrapDialog.confirm({
            title: 'Delete Address and Map',
            message: 'Do you really want to delete selected map? You can not restore after confirm it...',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function(result) {
                if(result) {
                    var check = true;
                    if(id != 0) {
                        $.ajax({
                            url: base_url + '/business/delete-map',
                            method: 'POST',
                            data: {
                                id: id
                            }
                        })
                        .done(function(data) {
                            if(data.result) {
                                $('#map-more-'+count).remove();
                            } else {
                                BootstrapDialog.show({
                                    title: 'Delete Address and Map',
                                    message: data.error,
                                    type: BootstrapDialog.TYPE_WARNING
                                });
                            }
                        })
                        .fail(function(xhr, status, error) {
                            console.log(this.url);
                            console.log(error);
                            console.log(xhr.responseText);
                        });
                    } else {
                        $('#map-more-'+count).remove();
                    }
                }
            }
        });
    });
}

function deleteRelate() {
    $('.btn-delete-related').off('click').on('click', function(e) {
        e.preventDefault();

        var count = $(this).data('count');
        var id = $('#related-item-' + count + ' input[name="related_id"]').val();

        BootstrapDialog.confirm({
            title: 'Delete Related Business',
            message: 'Do you really want to delete selected Related Business? You can not restore after confirm it...',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function(result) {
                if(result) {
                    if(id != 0) {
                        $.ajax({
                            url: base_url + '/business/delete-relate',
                            method: 'POST',
                            data: {
                                'id' : id
                            },
                        })
                        .done(function(data) {
                            if(data.result) {
                                $('#related-item-' + count).remove();
                            } else {
                                BootstrapDialog.show({
                                    title: 'Delete Related Business',
                                    message: data.error,
                                    type: BootstrapDialog.TYPE_WARNING
                                });
                            }
                        })
                        .fail(function(xhr, status, error) {
                            console.log(this.url);
                            console.log(error);
                            console.log(xhr.responseText);

                            BootstrapDialog.show({
                                title: 'Delete Related Business',
                                message: error,
                                type: BootstrapDialog.TYPE_WARNING
                            });
                        });
                    } else {
                        $('#related-item-' + count).remove();
                    }

                    if($('.related-item').length == 0) {
                        $('#related-list').html('<p id="relate-nothing" class="col-12 text-center">No Data</p>');
                    }
                }
            }
        });
    });
}

function deletePDFFile() {
    $('#btn-pdf-section a.delete-pdf').off('click').on('click', function(e) {
        e.preventDefault();

        BootstrapDialog.confirm({
            title: 'Delete PDF File',
            message: 'Do you really want to delete PDF file?',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function(result) {
                if(result) {
                    var pdf_url = $('input[name="pdf_url"]').val();

                    $.ajax({
                        url: base_url + '/business/delete-pdf',
                        method: 'POST',
                        data: {
                            'pdf_url': pdf_url
                        }
                    })
                    .done(function(data) {
                        if(data.result) {
                            var html = '<p id="pdf-nothing" class="g-col-2 g-col-md-4 g-col-lg-8 m-0 text-center mb-0">No Data</p>';

                            $('input[name="pdf_url"]').val('');

                            $('#pdf-list').html(html);

                            $('#btn-pdf-section input').val('');
                            $('#company-pdf .custom-input-file').addClass('d-inline-block').removeClass('d-none');
                            $('#company-pdf a').removeClass('d-inline-block').addClass('d-none');
                        } else {
                            BootstrapDialog.show({
                                title: 'Delete Business PDF',
                                message: 'Delete PDF Fail...',
                                type: BootstrapDialog.TYPE_WARNING
                            });
                        }
                    })
                    .fail(function(xhr, status, error) {
                        console.log(this.url);
                        console.log(error);
                        console.log(xhr.responseText);

                        BootstrapDialog.show({
                            title: 'Delete Business PDF',
                            message: error,
                            type: BootstrapDialog.TYPE_WARNING
                        });
                    });
                }
            }
        });
    });
}

function deleteGalleryImage() {
    $('.delete-gallery').off('click').on('click', function() {
        var id = $(this).data('id');

        BootstrapDialog.confirm({
            title: 'Delete Gallery Image',
            message: 'Do you really want to delete selectted Gallery Image?',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function(confirm) {
                if(confirm) {
                    $('#gallery-item-' + id).remove();

                    if($('.gallery-item').length < 100) {
                        $('#btn-add-gallery-area').removeClass('d-none');
                        if($('input.add-image-input').length == 0) {
                            $('#btn-add-gallery-area').append('<input id="general-upload" type="file" name="add_image[]" class="add-image-input" multiple>');
                            addImage();
                        }
                    } else {
                        $('input.add-image-input').remove();
                        $('#btn-add-gallery-area').addClass('d-none');
                    }
                }
            }
        })
    });
}

function deleteService() {
    $('.btn-delete-service').off('click').on('click', function(e) {
        e.preventDefault();

        var count = $(this).data('count');
        var id = $('#service-item-' + count + ' input[name="service_id"]').val();

        BootstrapDialog.confirm({
            title: 'Delete an Service',
            message: 'Do you really want to delte selected service?<br/>You can not restore your action..',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function(confirm) {
                if(confirm) {
                    if(id != 0) {
                        $.ajax({
                            url: base_url + '/business/delete-service',
                            method: 'POST',
                            data: {
                                'id': id
                            }
                        })
                        .done(function(data) {
                            if(data.result) {
                                $('#service-item-' + count).remove();
                            } else {
                                BootstrapDialog.show({
                                    title: 'Delete an Service',
                                    message: 'Have error when delete Service',
                                    type: BootstrapDialog.TYPE_WARNING
                                });
                            }
                        })
                        .fail(function(xhr, status, error) {
                            console.log(this.url);
                            console.log(error);
                            console.log(xhr.responseText);

                            BootstrapDialog.show({
                                title: 'Delete an Service',
                                message: 'Have error when delete Service',
                                type: BootstrapDialog.TYPE_WARNING
                            });
                        });
                    } else {
                        $('#service-item-' + count).remove();
                    }

                    if($('.service-item').length == 0) {
                        $('#service-list').html('<p id="service-nothing" class="g-col-2 g-col-md-4 g-col-lg-8 m-0 text-center mb-0">No Data</p>');
                    }
                }
            }
        })
    });
}

/*Helper Function*/
function loadImagePrimaryAddress() {
    $('#input-primary-img').on('change', function() {
        img_route_preview(this, 0);
    });
}

function previewImage(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('img[name="avatar_preview"]').attr('src', e.target.result).addClass('mb-1');
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function img_route_preview(input, index) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            if(index === 0) {
                $('form#primary-map-form img.img-map-preview').attr('src', e.target.result);
            } else {
                $('form.map-more-form[data-count="' + index + '"] img.img-map-preview').attr('src', e.target.result).addClass('mb-1');
            }
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function catchSubmitForm() {
    $('#business-content form').off('submit').on('submit', function(e) {
        e.preventDefault();

        $('#business-content button[type="submit"]').trigger('click');
    });
}

