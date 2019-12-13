// Facebook SDK Script
(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


// User sripts
$(document).ready(function() {
    $(window).on('scroll', function() {
        if (parseInt($('#mainNav').offset().top) > parseInt($('#header').outerHeight(true))) {
            $('#navbar-brand').removeClass('d-lg-none');
        } else {
            $('#navbar-brand').addClass('d-lg-none');
        }
    });

    $('#navbarNav').on('show.bs.collapse', function() {
        $('#body-main-content').addClass('d-none');
    }).on('hide.bs.collapse', function() {
        $('#body-main-content').removeClass('d-none');
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if (!$('#ajax-form-login').length) {
        doLogout();
    }


    $('#btn-save').on('click', function (e) {
        e.preventDefault();
        var post_id = $(this).data('id');
        var post_type = $(this).data('type');
        // From Main.js
        saveSavedLink(post_id, post_type);

    });
});

function doLogout() {
    $('a.btn-logout').on('click', function () {
        var logoutForm = $('#logout-form');

        logoutForm.submit();
    });
}

function previewImage(input, selectorPreview) {

}

function saveSavedLink(post_id, post_type) {

    $.ajax({
        url: base_url + '/account-setting/saved-link/add',
        method: 'POST',
        data: {
            'post_id': post_id,
            'post_type': post_type
        },
        async: true,

    })
    .done(function (data) {
        if(data.result) {
            if(data.liked) {

                $('#btn-save').removeClass('btn-save').addClass('btn-saved');
                $('#saved-result').html('You saved successfully');
                // alert('Saved')
            } else {
                $('#btn-save').removeClass('btn-saved').addClass('btn-save');
                $('#saved-result').html('You unsaved successfully');
            }
        }
    })
    .fail(function (xhr, status, error) {
        if (xhr.status == 422) {
            alert("Page is not saved yet")
        } else {
            console.log(this.url);
            console.log(error);
            console.log(xhr.responseText);
        }
    });
}
