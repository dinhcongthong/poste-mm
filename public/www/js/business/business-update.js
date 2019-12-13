$(document).ready(function() {
    
    $('#business-content button[type="submit"]').on('click', function(e) {
        e.preventDefault();
        
        $('.error').remove();
        
        var result = false;
        
        result = saveBasic();
        
        if (result) {
            window.location.href = base_url + '/business';
        }
    });
    
    
});


function saveBasic() {
    var result = false;
    
    var formData = new FormData($('#basic-info-form')[0]);
    var gallery_ids = [];
    $.each($('input[name="gallery_ids[]"]'), function(e) {
        gallery_ids.push($(this).val());
    });
    
    formData.append('gallery_ids', gallery_ids);
    formData.append('pdf_url', $('input[name="pdf_url"]').val());
    formData.append('business_id', $('input[name="business_id"]').val());
    
    $.ajax({
        data: formData,
        url: base_url + '/business/save-basic-info',
        method: 'POST',
        processData: false,
        contentType: false,
        async: false
    })
    .done(function(data) {
        console.log(data);
        if(data.result) {
            $('input[name="business_id"]').val(data.business_id);
            
            result = saveService();
        }
    })
    .fail(function(xhr, status, error) {
        if(xhr.status == 422) {
            var response = JSON.parse(xhr.responseText);
            var errors = response.errors;
            
            var html = '';
            html += '   <div class="alert alert-danger mb-3 w-100">';
            html += '       <ul class="mb-0">';
            $.each(errors, function (key, value) {
                html += '       <li>' + value + '</li>';
            });
            html += '       </ul>';
            html += '   </div>';
            $('html').animate({
                scrollTop: eval($('#basic-info-form').offset().top)
            }, 300);
            $('.name_errors').fadeIn();
            $('#name_errors').html(html).removeClass('d-none').fadeIn();
        } else {
            console.log(error);
            console.log(xhr.responseText);
        }
    });
    
    return result;
}

function saveService() {
    var result = true;
    if($('form.business-service-form').length >= 1) {
        // var idForm = $('form.business-service-form').length;
        // idform++;
        $('#error_notify').addClass('d-none');
        $.each($('form.business-service-form'), function() {
            var formData = new FormData(this);
            var formService = $(this);
            formData.append('business_id', $('input[name="business_id"]').val());
            
            $.ajax({
                url: base_url + '/business/save-service-info',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                async: false
            })
            .done(function(data) {
                if(!data.result) {
                    result = false;
                } else {
                    formService.find('input[name="service_id"]').val(data.id);
                    console.log(formService.find('input[name="service_id"]').val());
                }
            })
            .fail(function(xhr, status, error) {
                // console.log(error);
                // console.log(xhr.responseText);
                result = false;
                if(xhr.status == 422) {
                    var response = JSON.parse(xhr.responseText);
                    var errors = response.errors;
                    
                    var html = '';
                    html += '   <div class="alert alert-danger mb-3 w-100 error">';
                    html += '       <ul class="mb-0">';
                    $.each(errors, function (key, value) {
                        html += '       <li>' + value + '</li>';
                    });
                    html += '       </ul>';
                    html += '   </div>';
                    $('html').animate({
                        scrollTop: eval(formService.offset().top - 150)
                    }, 300);
                    formService.find('input[type="hidden"]').before(html);
                } 
            });
            if(!result) {
                return result;
            }
        });
    }
    
    if(result) {
        result = saveRelatedBusiness();
    }
    
    return result;
}

function saveRelatedBusiness() {
    var result = true;
    
    if($('form.related-form').length >= 1) {
        $.each($('form.related-form'), function() {
            var formRelate = $(this);
            var formData = new FormData(this);
            formData.append('business_id', $('input[name="business_id"]').val());
            
            $.ajax({
                url: base_url + '/business/save-related-business',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                async: false
            })
            .done(function(data) {
                if(data.result) {
                    formRelate.find('input[name="related_id"]').val(data.id);
                    console.log(data.id);
                    result = true;
                } else {
                    result = false;
                }
            })
            .fail(function(xhr, status, error) {
                console.log(this.url);
                console.log(error);
                console.log(xhr.responseText);
                if (xhr.status == 422) {
                    var response = JSON.parse(xhr.responseText);
                    var errors = response.errors;
                    
                    var html = '';
                    html += '   <div class="alert alert-danger mb-3 w-100 error">';
                    html += '       <ul class="mb-0">';
                    $.each(errors, function (key, value) {
                        html += '       <li>' + value + '</li>';
                    });
                    html += '       </ul>';
                    html += '   </div>';
                    $('html').animate({
                        scrollTop: eval(formRelate.offset().top - 150)
                    }, 300);
                    formRelate.find('div.card').before(html);
                }
                result = false;
            });
            
            if(!result) {
                result = false;
            }
        });
    }
    
    if(result) {
        result = savePrimaryAddress();
    }
    
    return result;
}

function savePrimaryAddress() {
    var formData = new FormData($('#primary-map-form')[0]);
    var form = $('#primary-map-form');
    
    formData.append('business_id', $('input[name="business_id"]').val());
    var result = true;
    
    $.ajax({
        url: base_url + '/business/save-primary-address',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        async: false
    })
    .done(function(data) {
        console.log(data);
        if(data.result) {
            result = saveAddress();
        }
    })
    .fail(function(xhr, status, error) {
        console.log(this.url);  
        console.log(error);
        console.log(xhr.responseText);
        
        if (xhr.status == 422) {
            var response = JSON.parse(xhr.responseText);
            var errors = response.errors;
            
            var html = '';
            html += '   <div class="alert alert-danger mb-3 w-100 error">';
            html += '       <ul class="mb-0">';
            $.each(errors, function (key, value) {
                html += '       <li>' + value + '</li>';
            });
            html += '       </ul>';
            html += '   </div>';
            $('html').animate({
                scrollTop: eval(form.offset().top - 150)
            }, 300);
            form.find('div.card').before(html);

            result = false;
        }
    });
    return result;
}

function saveAddress() {
    var result = true;
    
    $.each($('.map-more-form'), function() {
        
        var formData = new FormData(this);
        var form = $(this);
        formData.append('business_id', $('input[name="business_id"]').val());
        
        $.ajax({
            url: base_url + '/business/save-more-map',
            data: formData,
            method: 'POST',
            processData: false,
            contentType: false,
            async: false
        })
        .done(function(data) {
            if(data.result) {
                form.find('input[name="branch_id"]').val(data.id);
                result = true;
            } else {
                console.log('Error when save More Map');
                result = false;
            }
        })
        .fail(function(xhr, status, error) {
            console.log(this.url);
            console.log(error);
            console.log(xhr.responseText);
            if (xhr.status == 422) {
                var response = JSON.parse(xhr.responseText);
                var errors = response.errors;
                
                var html = '';
                html += '   <div class="alert alert-danger mb-3 w-100 error">';
                html += '       <ul class="mb-0">';
                $.each(errors, function (key, value) {
                    html += '       <li>' + value + '</li>';
                });
                html += '       </ul>';
                html += '   </div>';
                $('html').animate({
                    scrollTop: eval(form.offset().top - 150)
                }, 300);
                form.find('div.card').before(html);
            }
            result = false;
        });
        
        if(!result) {
            return false;
        }
    });
    
    return result;
}
