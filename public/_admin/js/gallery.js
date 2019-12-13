$(document).ready(function () {
    $('.div-img-center').on('click', function (e) {
        e.preventDefault();
        
        var url = $(this).data('url');
        
        prompt('Ctrl + C to copy URL', url);
    });
});