$(document).ready(function() {
    if ($('#textarea-content').length) {
        CKEDITOR.replace('textarea-content', {
            toolbar: 'Basic'
        });
    }
    
    if ($('#requirement-content').length) {
        CKEDITOR.replace('requirement-content', {
            toolbar: 'Basic'
        });
    }
    
    if ($('#textarea-other-content').length) {
        CKEDITOR.replace('textarea-other-content', {
            toolbar: 'Basic'
        });
    }
    if($('#input-image1').length) {
        $('#input-image1').fileinput({
            theme: 'fas',
            initialPreview: [
                $('input[name="pre_image1"]').val()
            ],
            initialPreviewConfig: [
                { caption: 'Image 1' }
            ],
            overwriteInitial: true,
            initialPreviewAsData: true,
            showUpload: false,
            maxFileSize: 2049,
            showRemove: true,
            maxFileCount: 1,
            validateInitialCount: true,
            allowedFileExtensions: ['jpg', 'png', 'jpeg', 'gif'],
        });
        
        $('#input-image1').on('fileclear', function (event) {
            $('input[name="pre_image1"]').val('');
        });
    }
    
    if ($('#input-image2').length) {
        $('#input-image2').fileinput({
            theme: 'fas',
            initialPreview: [
                $('input[name="pre_image2"]').val()
            ],
            initialPreviewConfig: [
                { caption: 'Image 2' }
            ],
            overwriteInitial: true,
            initialPreviewAsData: true,
            showUpload: false,
            maxFileSize: 2049,
            showRemove: true,
            maxFileCount: 1,
            validateInitialCount: true,
            allowedFileExtensions: ['jpg', 'png', 'jpeg', 'gif'],
        });
        
        $('#input-image2').on('fileclear', function (event) {
            $('input[name="pre_image2"]').val('');
        });
    }
    
    if($('input[name="start_date"]').length) {
        $('input[name="start_date"]').datetimepicker({
            format: 'YYYY-MM-DD',
        });
        
        var startDate = $('input[name="start_date"]').val();
        
        if (startDate) {
            $('input[name="end_date"]').datetimepicker({
                format: 'YYYY-MM-DD',
                minDate: moment($('input[name="start_date"]').val(), 'YYYY-MM-DD')
            });
        } else {
            $('input[name="end_date"]').datetimepicker({
                format: 'YYYY-MM-DD',
            });
        }
        
        $('input[name="start_date"]').on('dp.change', function (e) {
            $('input[name="end_date"]').datetimepicker('destroy').datetimepicker({
                format: 'YYYY-MM-DD',
                minDate: e.date
            });
        });
    }
    
    deleteItem();
    
    // Detail
    if($('#popup-image').length) {
        $('#popup-image').magnificPopup({
            delegate: 'a',
            type: 'image',
            tLoading: 'Loading image #%curr%...',
            mainClass: 'mfp-img-mobile',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0, 1]
                
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                titleSrc: function (item) {
                    return item.el.attr('title') + '<small>by Poste-mm.com</small>';
                }
            },
            zoom: {
                enabled: true,
                duration: 500
            }
        });
    }
    
    if ($('select[name="city_search_id"]').length && $('select[name="district_search_id"]').length) {
        $('select[name="city_search_id"]').on('change', function() {
            var city_id = $(this).val();
            
            $.ajax({
                url: base_url + '/ajax/get-district-from-city/' + city_id,
                method: 'GET'
            })
            .done(function(data) {
                if(data.result) {
                    $('select[name="district_search_id"]').html(data.view);
                }
            })
            .fail(function(xhr, status, error) {
                console.log(this.url);
                console.log(error);
                console.log(xhr.responseText);
            });
        });
    }
    
    if ($('select[name="city_id"]').length && $('select[name="district_id"]').length) {
        $('select[name="city_id"]').on('change', function() {
            var city_id = $(this).val();
            
            $.ajax({
                url: base_url + '/ajax/get-district-from-city/' + city_id,
                method: 'GET'
            })
            .done(function(data) {
                if(data.result) {
                    $('select[name="district_id"]').html(data.view);
                }
            })
            .fail(function(xhr, status, error) {
                console.log(this.url);
                console.log(error);
                console.log(xhr.responseText);
            });
        });
    }
    
    if ($('#option-realestate input[name="type_id"]').length) {
        typeId = $('#option-realestate input[name="type_id"]:checked').val();
        if(typeof typeId === "undefined") {
            typeId = 20;
        }
        if (typeId == 20) {
            $('#personal-image-div').removeClass('d-none').addClass('d-flex');
            $('#personal-delivery-select').removeClass('d-none').addClass('d-flex');
        } else {
            $('#personal-image-div').removeClass('d-flex').addClass('d-none');
            $('#personal-delivery-select').removeClass('d-flex').addClass('d-none');
        }
        
        $('#option-realestate input[name="type_id"]').on('click', function() {
            var typeId = $(this).val();
            
            if(typeId == 20) {
                $('#personal-image-div').removeClass('d-none').addClass('d-flex');
                $('#personal-delivery-select').removeClass('d-none').addClass('d-flex');
            } else {
                $('#personal-image-div').removeClass('d-flex').addClass('d-none');
                $('#personal-delivery-select').removeClass('d-flex').addClass('d-none');
            }
        });
    }
    
    contact();
});

function deleteItem() {
    $('.btn-delete').on('click', function (e) {
        e.preventDefault();
        
        var btn = $(this);
        var id = btn.data('id');
        var typeData = btn.data('type');
        
        var ajaxURL = '';
        var titleShow = '';
        
        switch (typeData) {
            case 'bullboard':
            ajaxURL = base_url + '/bullboard/delete';
            titleShow = 'Delete An Bullboard Article';
            break;
            case 'personal':
            ajaxURL = base_url + '/personal-trading/delete';
            titleShow = 'Delete An Personal Trading Article';
            break;
            case 'job-searching':
            ajaxURL = base_url + '/job-searching/delete';
            titleShow = 'Delete An Job Searching Article';
            break;
            case 'real-estate':
            ajaxURL = base_url + '/real-estate/delete';
            titleShow = 'Delete An RealEstate Article';
            break;
        }
        
        if (ajaxURL == '') {
            console.log('error');
            return false;
        }
        
        BootstrapDialog.confirm({
            title: titleShow,
            message: 'Do you really want to delete selected article?',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function (result) {
                if (result) {
                    $.ajax({
                        url: ajaxURL,
                        method: 'POST',
                        data: {
                            'id': id
                        }
                    })
                    .done(function (data) {
                        if (data.result) {
                            $('#data-table').html(data.view);
                            
                            deleteItem();
                            
                            BootstrapDialog.show({
                                title: titleShow,
                                message: 'Delete Article Successfully',
                                type: BootstrapDialog.TYPE_SUCCESS
                            });
                        } else {
                            BootstrapDialog.show({
                                title: titleShow,
                                message: data.error,
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

var countClick = 0;
function contact() {
    $('#contact-classify-form').on('submit', function (e) {
        e.preventDefault();
        countClick++;
        $('#mail_feedback').addClass('disabled');

        var typeClassify = $(this).data('type');
        var id = $(this).data('key');
        var urlAjax = '';
        
        switch(typeClassify) {
            case 'bullboard':
            urlAjax = base_url + '/bullboard/contact/' + id;
            break;
            case 'personal':
            urlAjax = base_url + '/personal-trading/contact/' + id;
            break;
            case 'job-searching':
            urlAjax = base_url + '/job-searching/contact/' + id;
            break;
            case 'real-estate':
            urlAjax = base_url + '/real-estate/contact/' + id;
            break;
        }
        
        if(urlAjax == '') {
            console.log('error');
            return false;
        }
        
        var dataContact = $(this).serialize();
        if (countClick == 1) {
            $.ajax({
                url: urlAjax,
                data: dataContact,
                method: 'POST'
            })
            .done(function (data) {
                countClick = 0;
                $('#mail_feedback').removeClass('disabled');
                if (data.result) {
                    $('#classify-contact').modal('hide');
                    
                    BootstrapDialog.show({
                        title: '投稿者への連絡が完了しました。',
                        message: 'ご入力いただいた内容が、投稿者に送信されました。<br/>投稿者からのご返信をお待ちください。<br/>しばらくすると、POSTEトップページに自動的に移動します。',
                        type: BootstrapDialog.TYPE_SUCCESS
                    });
                } else {
                    BootstrapDialog.show({
                        title: '投稿者への連絡が完了しました。',
                        message: data.error,
                        type: BootstrapDialog.TYPE_WARNING
                    })
                }
            })
            .fail(function (xhr, status, error) {
                console.log(this.url);
                console.log(error);
                console.log(xhr.responseText);
            });
        }
    });
}