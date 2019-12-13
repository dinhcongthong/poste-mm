$(document).ready(function() {
    $('.editable-item[readonly]').click(function () {
        $('#edit-button').click();
    });
    
    $('.modal').on('hide.bs.modal', function (e) {
        $('.editable-item').attr('readonly', true).addClass('form-control-plaintext').removeClass('form-control');
        $('#edit-button').attr({ type: 'button', onclick: 'requestEdit()' }).removeClass('btn-primary').addClass('btn-success').html('<i class="material-icons" style="font-size: 14px;">edit</i> 情報の修正を提案');
        $('#status').removeClass('text-primary').addClass('text-success').html('<i class="material-icons" style="font-size: 18px;">update</i> Updated');
        $('.col-form-label').removeClass('text-primary').addClass('text-success');
        $('#close-button').text('閉じる');
    });
    
    $('#businessSearch').on('shown.bs.collapse', function (e) {
        $('#b-search-input').focus();
    });
    
    if($('#detail-gallery-list').length) {
        $('#detail-gallery-list').magnificPopup({
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

        loadMoreImages();
    }
    
    if($('.business-detail-map-item').length) {
        $('.business-detail-map-item a').on('click', function(e) {
            e.preventDefault();
            $('.business-detail-map-item.active').removeClass('active');
            var map_item = $(this).parents().eq(2);
            map_item.addClass('active');
            
            var map_src = $(this).data('map');
            if(map_src !== '') {
                $('#map-iframe').attr('src', map_src).removeClass('d-none');
                $('#no-map-image').addClass('d-none');
            } else {
                $('#map-iframe').attr('src', map_src).addClass('d-none');
                $('#no-map-image').removeClass('d-none');
            }
            
            if($(this).hasClass('preview')) {
                var image_src = $(this).find('img').attr('src');
                var address = map_item.find('h4.address').text();
                $('#image-route-guide-modal img').attr('src', image_src);
                $('#image-route-guide-modal .address').text(address);
                $('#image-route-guide-modal').modal('show');
            }
        });
    }
    
    if($('#relate-list').length) {
        var relate_swiper = new Swiper('#relate-list > .swiper-container', {
            slidesPerView: 3,
            spaceBetween: 30,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            autoplay: {
                delay: 2500,
            },
            breakpoints: {
                991.99: {
                    slidesPerView: 2
                },
                767.99: {
                    slidesPerView: 1
                }
            }
        });
    }
    
    /* Edit */
    
    var swiper = new Swiper('#header-cate-list', {
        slidesPerView: 9,
        spaceBetween: 10,
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
                slidesPerView: 2.5,
                spaceBetween: 10,
            },
            320: {
                slidesPerView: 1.5,
                spaceBetween: 10,
            }
        }
    });
    
    // Feedback Js
    var countClick = 0;
    $('#feedback-form').on('submit', function(e) {
        e.preventDefault();
        countClick++;
        $('#mail_feedback').addClass('disabled');
        var formData = $(this).serialize();
        
        console.log(formData);
        if (countClick == 1) {
            
            $.ajax({
                url: base_url + '/business/send-feedback',
                method: 'POST',
                data: formData
            })
            .done(function (data) {
                console.log(data);
                countClick = 0;
                $('#mail_feedback').removeClass('disabled');
                if (data.result) {
                    $('#feedback-modal').modal('hide');
                    
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
});

function requestEdit() {
    $('.editable-item').removeAttr('readonly').removeClass('form-control-plaintext').addClass('form-control');
    $('#edit-button').removeAttr('onclick').attr('type', 'submit').removeClass('btn-success').addClass('btn-primary').text('送信');
    $('#status').removeClass('text-success').addClass('text-primary').html('<i class="material-icons" style="font-size: 18px;">error</i> 間違っている情報をクリックしてください');
    $('.col-form-label').removeClass('text-success').addClass('text-primary');
    $('#close-button').text('取消');
}


// load more images in detail page
function loadMoreImages () {
    $('#load-more-images').on('click', function () {
        var page = $(this).data('page') + 1;
        var id = $(this).data('id');
        var name = $(this).data('name');
        $.ajax({
            url: base_url + '/business/load-more-images',
            data: {
                id: id,
                name: name,
                page: page
            },
            method: 'GET',
        })
        .done(function (data) {
            console.log(data);
            if (data.result) {
                console.log('sc');
                $('#detail-gallery-list').append(data.html);
                if (page == data.total_page) {
                    $('#load-more-images').remove();
                } else {
                    $('#load-more-images').data('page', page);
                }
            }
        })
        .fail(function (xhr, status, error) {
            console.log(this.url);
            console.log(error);
            console.log(xhr.responseText);
        });
    });
}
