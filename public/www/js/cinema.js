 $(document).ready(function() {
    $('.btn-trailer').on('click', function() {
        var youtube_id = $(this).data('trailer');
        
        $('#trailer-frame').attr('src', 'https://www.youtube.com/embed/'+ youtube_id);
        
        $('#trailer').on('hide.bs.modal', function() {
            $('#trailer-frame').attr('src', 'https://www.youtube.com/embed/');
        });
    });
});