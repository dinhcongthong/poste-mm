$(document).ready(function() {

    // Submit update
    $('button[type="submit"]').on('click', function () {
        submitForm();
    });
});

function submitForm() {
    var result = false;
    $('.error-area').remove();

    $('#shop-update').removeClass('d-block').fadeOut();
    $('#loading').removeClass('d-none').fadeIn();

    // Add Town item
    result = saveBasicInfo();

    // Finish
    if (result) {
        window.location.href = base_url + '/town';
    } else {
        resetProcessing();
        if($('.error-area').length) {
            $('html').animate({
                scrollTop: eval($('.error-area').offset().top - 150)
            }, 300);
        }
    }
}

// Catch submit add-basic form
function saveBasicInfo() {
    var town_id = $('input[name="town_id"]').val();
    var category_id = $('input[name="category_id"]').val();
    var description = $('textarea[name="description"]').val();
    var map = $('input[name="map"]').val();
    var pdf_ids = $('input[name="pdf_ids"]').val();

    var formData = new FormData($('#add-step2-form')[0]);
    formData.append('town_id', town_id);
    formData.append('category_id', category_id);
    formData.append('description', description);
    formData.append('map', map);
    formData.append('pdf_ids', pdf_ids);

    var result = false;

    $.ajax({
        url: base_url + '/town/add-basic-info',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        async: false
    })
    .done(function (data) {
        if (data.result) {
            $('input[name="town_id"]').val(data.town_id);
            if ($('#working-time-form').length) {
                result = saveWorkingTime();
            } else {
                result = saveGallery();
            }
        } else {
            var html = '<p class="alert alert-danger error-area rounded-0">Have errors while processing. Please check again...</p>';
            $('#basic-info-error').html(html);

            result = false;
        }
    })
    .fail(function (xhr, status, error) {
        console.log('basic error');
        if (xhr.status == 422) {
            var response = JSON.parse(xhr.responseText);
            var errors = response.errors;

            var html =  '<div class="alert alert-danger error-area rounded-0">';
            html +=     '   <ul class="mb-0 w-100">';
            $.each(errors, function (key, value) {
                html += '       <li>' + value + '</li>';
            });
            html +=     '   </ul>';
            html +=     '</div>';

            $('#basic-info-error').html(html);
        } else {
            console.log(this.url);
            console.log(error);
            console.log(xhr.responseText);
        }
        result = false;
    });
    return result;
};

function saveWorkingTime() {
    var formData = new FormData($('#working-time-form')[0]);
    formData.append('town_id', $('input[name="town_id"]').val());

    var result = false;

    $.ajax({
        url: base_url + '/town/update-working-time',
        data: formData,
        method: 'POST',
        contentType: false,
        processData: false,
        async: false
    })
    .done(function (data) {
        if (data.result) {
            result = saveGallery();
            // result = saveRegularClose();
        } else {
            $('#working-time-errrors').html('<p class="error-area alert alert-danger">Have errors while processing. Please check again...</p>');
            result = false;
        }
    })
    .fail(function (xhr, status, error) {
        console.log(this.url);
        console.log(error);
        console.log(xhr.responseText);

        $('#working-time-errrors').html('<p class="error-area alert alert-danger">Have errors while processing. Please check again... Error code 422</p>');

        result = false;
    });

    return result;
}

function saveRegularClose() {
    var formData = new FormData($('#regular-close-form')[0]);
    formData.append('town_id', $('input[name="town_id"]').val());

    var result = false;

    $.ajax({
        url: base_url + '/town/update-regular-closing',
        data: formData,
        method: 'POST',
        contentType: false,
        processData: false,
        async: false
    })
    .done(function (data) {
        if (data.result) {
            result = saveGallery();
        } else {
            $('#errors').text('Have errors while processing. Please check again...').removeClass('d-none').fadeIn();
            result = false;
        }
    })
    .fail(function (xhr, status, error) {
        console.log(this.url);
        console.log(error);
        console.log(xhr.responseText);
        result = false;
    });

    return result;
}

function saveGallery() {
    var space_list = $('input[name="space_list"]').val();
    var food_list = $('input[name="food_list"]').val();
    var menu_list = $('input[name="menu_list"]').val();
    var general_list = $('input[name="general_list"]').val();
    var town_id = $('input[name="town_id"]').val();

    var result = false;

    $.ajax({
        url: base_url + '/town/save-gallery',
        method: 'POST',
        data: {
            'town_id': town_id,
            'space_ids': space_list,
            'menu_ids': menu_list,
            'food_ids': food_list,
            'general_ids': general_list
        },
        async: false
    })
    .done(function (data) {
        if (!data.result) {
            $('#gallery-errors').html('<p class="error-area alert alert-danger">Have errors while processing. Please check again...</p>');

            result = false;
        } else {
            result = saveFeatures();
        }
    })
    .fail(function (xhr, status, error) {
        $('#gallery-errors').html('<p class="error-area alert alert-danger">Have errors while processing. Please check again...Error code 422</p>');

        result = false;

        console.log(this.url);
        console.log(error);
        console.log(xhr.responseText);
    });
    return result;
}

function saveFeatures() {
    var town_id = $('input[name="town_id"]').val();
    var category_id = $('input[name="category_id"]').val();

    var formData = new FormData($('#add-features-form')[0]);
    formData.append('town_id', town_id);
    formData.append('category_id', category_id);

    var result = false;

    $.ajax({
        url: base_url + '/town/add-features-info',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        async: false
    })
    .done(function (data) {
        if (data.result != 1) {
            $('#feature-errors').html('<p class="error-area alert alert-danger">Have errors while processing. Please check again...</p>');
            result = false;
        } else {
            if ($('.menu-form').length > 0) {
                $.each($('.menu-form'), function (index, value) {
                    result = saveMenu($(this));

                    if (!result) {
                        result = false;
                    }
                });
            } else {
                result = true;
            }


        }
    })
    .fail(function (xhr, status, error) {
        console.log(this.url);
        console.log(error);
        console.log(xhr.responseText);

        $('#feature-errors').html('<p class="error-area alert alert-danger">Have errors while processing. Please check again... Error code 422</p>');

        result = false;
    });
    return result;
}

function saveMenu(form) {
    if ($('#menu').length == 0) {
        return true;
    }

    var formData = new FormData(form[0]);
    var imgFoodArr = [];
    $.each($(this).find('input[name="food_image[]"]'), function (index, value) {
        if (this.files[0]) {
            imgFoodArr.push(this.files[0]);
        } else {
            imgFoodArr.push('');
        }
    });

    var result = false;

    formData.append('town_id', $('input[name="town_id"]').val());
    formData.append('imgFoods', JSON.stringify(imgFoodArr));
    $.ajax({
        url: base_url + '/town/save-menu',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        async: false
    })
    .done(function (data) {
        result = false;
    })
    .fail(function (xhr, status, error) {
        if (xhr.status == 422) {
            var response = JSON.parse(xhr.responseText);
            var errors = response.errors;

            console.log(form.find('.food-item').length);

            $.each(form.find('.food-item'), function(index) {
                var html = '';

                if(errors['food_name.'+ index]) {
                    var err_list = errors['food_name.'+ index];
                    var html =  '<div class="error-area col-12 mb-1 alert alert-danger"><ul class="m-0 pl-2">';
                    err_list.forEach(function(err, index) {
                        html += '   <li>' + err + '</li>';
                    });
                }

                if(errors['imgFoods.'+index]) {
                    var err_list = errors['imgFoods.'+index];

                    if(html === '') {
                        var html =  '<div class="error-area col-12 mb-1 alert alert-danger"><ul class="m-0 pl-2">';
                    }

                    err_list.forEach(function(err, index) {
                        html += '   <li>' + err + '</li>';
                    });
                }

                if(html !== '') {
                    html +=     '</ul></div>';
                }

                $(this).prepend(html);
            });
        } else {
            console.log(this.url);
            console.log(error);
            console.log(xhr.responseText);
        }
        result = false;
    });

    return result;
};

function resetProcessing() {
    $('#loading').fadeOut();
    $('#shop-update').fadeIn();
}

function saveSavedLink() {
    var town_id = $('input[name="town_id"]').val();
    var category_id = $('input[name="category_id"]').val();
    var description = $('textarea[name="description"]').val();
    var map = $('input[name="map"]').val();
    var pdf_ids = $('input[name="pdf_ids"]').val();

    var formData = new FormData($('#add-step2-form')[0]);
    formData.append('town_id', town_id);
    formData.append('category_id', category_id);
    formData.append('description', description);
    formData.append('map', map);
    formData.append('pdf_ids', pdf_ids);

    var result = false;

    $.ajax({
        url: base_url + '/town/add-basic-info',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        async: false
    })
    .done(function (data) {
        console.log('Data Basic');
        console.log(data);
        console.log('End Data Basic');

        if (data.result) {
            $('input[name="town_id"]').val(data.town_id);
            if ($('#working-time-form').length) {
                result = saveWorkingTime();
            } else {
                result = saveGallery();
            }
        } else {
            $('#errors').text('Have errors while processing. Please check again...').removeClass('d-none').fadeIn();
            resetProcessing();
            result = false;
        }
    })
    .fail(function (xhr, status, error) {
        console.log('basic error');
        if (xhr.status == 422) {
            var response = JSON.parse(xhr.responseText);
            var errors = response.errors;

            var html =  '<div class="alert alert-danger error-are">';
            html +=         '<ul class="mb-0 w-100">';
            $.each(errors, function (key, value) {
                html += '<li>' + value + '</li>';
            });
            html += '</ul>';
            html += '</div>';

            resetProcessing();
            $('#basic-info-error').html(html).removeClass('d-none').fadeIn();
        } else {
            console.log(this.url);
            console.log(error);
            console.log(xhr.responseText);
        }
        result = false;
    });
    return result;
};
