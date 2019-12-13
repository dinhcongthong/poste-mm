$(document).ready(function() {
    $('#premiumSearch').on('shown.bs.collapse', function (e) {
        $('#b-search-input').focus();
    });
    
    $('#gallerybox').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var albums = button.data('albums') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find(albums).tab('show')
    });
    
    $('#form-search, #premium-search select').on('focus', function () {
        $('#premium-search').addClass('focusing');
    });
    $('#form-search, #premium-search select').on('focusout', function () {
        $('#premium-search').removeClass('focusing');
    });
    
    var swiper = new Swiper('#header-cate-list', {
        slidesPerView: 11,
        spaceBetween: 0,
        scrollbar: {
            el: '.swiper-scrollbar',
            hide: false,
        },
        breakpoints: {
            1024: {
                slidesPerView: 5.5,
                spaceBetween: 10,
            },
            768: {
                slidesPerView: 4.5,
                spaceBetween: 10,
            },
            640: {
                slidesPerView: 3.5,
                spaceBetween: 10,
            },
            320: {
                slidesPerView: 2.5,
                spaceBetween: 10,
            }
        }
    });
    
    
    // Feedback Js
    var countClick = 0;
    $('#feedback-form').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        $('#mail_feedback').addClass('disabled');
        countClick++;
        if (countClick == 1) {
            $.ajax({
                url: base_url + '/town/send-feedback',
                method: 'POST',
                data: formData
            })
            .done(function (data) {
                console.log(data);
                if (data.result) {
                    $('#feedback-modal').modal('hide');
                    $('#mail_feedback').removeClass('disabled');
                    countClick = 0;
                    BootstrapDialog.show({
                        title: 'Send FeedBack',
                        message: 'We received your feedback!!<br/>Thanks very much',
                        type: BootstrapDialog.TYPE_SUCCESS
                    });
                } else {
                    var html = '    <div class="form-group">';
                    html += '           <div class="alert alert-danger">';
                    html += '               <p class="m-0">';
                    html += '                   So sorry!!!<br/>';
                    html += '                   Have errors while process your request. <br/>';
                    html += '                   <strong>Please try again...</strong>';
                    html += '               </p>'
                    html += '           </div>';
                    html += '       </div>';
                    
                    $('#feedback-modal').find('.modal-body').after(html);
                    $('#feedback-modal').modal('show');
                }
            })
            .fail(function (xhr, status, error) {
                if (xhr.status == 422) {
                    var response = JSON.parse(xhr.responseText);
                    var errors = response.errors;
                    
                    var html = '    <div class="alert alert-danger error-are">';
                    html += '           <ul class="mb-0 w-100">';
                    $.each(errors, function (key, value) {
                        html += '           <li>' + value + '</li>';
                    });
                    html += '           </ul>';
                    html += '       </div>';
                    
                    $('#feedback-form').find('.modal-body').append(html);
                    
                    $('#feedback-modal').modal('show');
                } else {
                    console.log(this.url);
                    console.log(error);
                    console.log(xhr.responseText);
                }
            });
        }
        
    });
    // End feedback js
    
    // $('#btn-save').on('click', function (e) {
    //     e.preventDefault();
    //     // From Main.js
    //     saveSavedLink();
    
    // });
});
