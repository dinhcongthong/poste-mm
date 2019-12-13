$(document).ready(function () {

    $('#load-more-button').on('click', function () {
        var page = $(this).data('page') + 1;
        console.log(page);
        $.ajax({
            url: base_url + '/account-setting/saved-link/load-data-more?page=' + page,
            method: 'GET',
        })
            .done(function (data) {
                console.log(data);
                if (data.result) {
                    console.log('sc');
                    $('#post_data_ago').append(data.html);
                    if (page == data.total_page) {
                        $('#load-more-button').remove();
                    } else {
                        $('#load-more-button').data('page', page);
                    }
                }
            })
            .fail(function (xhr, status, error) {
                console.log(this.url);
                console.log(error);
                console.log(xhr.responseText);
            });
    });

    // $(document).on('click', '#load_more_button', function(){
    //     var id = $(this).data('id');
    //     $('#load_more_button').html('<b>Loading...</b>');
    //     load_data_more_aj(id);
    // });

    $('.unsave').on('click', function () {
        // alert('HEllo');
        var id = $(this).attr('data-id');
        var unsave = $('saved-item').attr('data-id');

        // console.log(id);

        var result = false;

        BootstrapDialog.confirm({
            title: 'Unsave page',
            message: 'Do you really want to unsave saved link? You can not restore after confirm it...',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function (result) {
                if (result) {
                    $.ajax({
                        url: base_url + '/account-setting/saved-link/unsavelink',
                        method: "POST",
                        data: {
                            'id': id
                            // 'unsave': unsave
                        },
                        async: true,
                    })
                        .done(function (data) {
                            console.log(id);
                            console.log('Unsave done');
                            location.reload();
                        })
                        .fail(function (xhr, status, error) {
                            console.log('basic error');
                            if (xhr.status == 422) {
                                alert("Link is not deleted yet")
                            } else {
                                console.log(this.url);
                                console.log(error);
                                console.log(xhr.responseText);
                            }
                            // result = false;
                        });
                }
            }
        });
    });

    // show search result
    var inputVal = $(this).val();
    $('input.typeahead').on("keyup input", function () {
        // searchLink();
        // function searchLink(){
        var inputVal = $(this).val();
        console.log(inputVal);
        var resultDropdown = $('.result_saved_link');
        $.ajax({
            url: base_url + '/account-setting/saved-link/auto-dropdown-saved-link',
            method: "GET",
            async: true,
            data: {
                'name_post': inputVal
            }
        })
            .done(function (data) {
                console.log(data);
                if ($('input.typeahead').val() != '') {
                    if ($('._town').is(':checked') || $('._business').is(':checked')) {
                        $("._town").prop("checked", true);
                        $("._business").prop("checked", true);
                    }
                    $('#sort').html(data);
                    $('.saved-timeline').hide();
                    $('#post_data_recent').hide();
                    $('#post_data_ago').hide();
                }
                else {
                    $('#sort').hide();
                    $('.saved-timeline').show();
                    // $('.result_saved_link').show();
                    $('#post_data_recent').show();
                    $('#post_data_ago').show();
                }
            })
            .fail(function (xhr, status, error) {
                console.log(this.url);
                console.log(error);
                console.log(xhr.responseText);
            });

        // }

    });

    // -------------
    $('.the_town').on("click", function () {
        if (!$('._town').is(':checked')) {
            $('.saved-town').addClass('appear');
        }
        else {
            $('.saved-town').removeClass('appear').addClass('disappear');
        }
    });

    $('.the_business').on("click", function () {
        if (!$('._business').is(':checked')) {
            $('.saved-business').addClass('appear');
        }
        else {
            $('.saved-business').removeClass('appear').addClass('disappear');
        }
    });

    // Close search button
    $(".clearable").each(function () {
        var $inp = $(this).find("input:text"),
            $cle = $(this).find(".clearable__clear");

        // $inp.on("input", function(){
        //     $cle.toggle(!!this.value);
        // });

        $cle.on("touchstart click", function (e) {
            e.preventDefault();
            // Clear text input
            $inp.val("").trigger("input");
            $('#sort').html('');
            $('.saved-timeline').show();
            $('#post_data_recent').show();
            $('#post_data_ago').show();
        });
    });
});