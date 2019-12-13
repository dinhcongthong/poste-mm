$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $('.select2').select2();
    
    $('.select2-no-search').select2({
        minimumResultsForSearch: -1
    });
    
    $('input[type="file"]').on('change', function() {
        var maxSize = $(this).data('max-size');
        
        if(maxSize) {
            if (window.File && window.FileReader && window.FileList && window.Blob)
            {
                //get the file size and file type from file input field
                var fsize = $(this)[0].files[0].size;
                var ftype = $(this)[0].files[0].type;
                var fname = $(this)[0].files[0].name;
                
                if(fsize>maxSize*1024*1024) //do something if file size more than 1 mb (1048576)
                {
                    alert("Type :"+ ftype +" | "+ fsize/1024/1024 +" MB\n(File: "+fname+") Too big!");
                    $(this).val('');
                }
            }else{
                alert("Please upgrade your browser, because your current browser lacks some new features we need!");
            }
        }
    });

    $('a.btn-logout').on('click', function() {
        var logoutForm = $('#logout-form');

        logoutForm.submit();
    });
});

function MyBootstrapShow(titleStr, messageStr, typeStr) {
    if(typeStr === 'warning') {
        typeStr = BootstrapDialog.TYPE_WARNING;
    } else if(typeStr === 'success') {
        typeStr = BootstrapDialog.TYPE_SUCCESS;
    } else if(typeStr === 'danger') {
        typeStr = BootstrapDialog.TYPE_DANGER;
    }

    BootstrapDialog.show({
        title: titleStr,
        message: messageStr,
        type: typeStr
    });
}