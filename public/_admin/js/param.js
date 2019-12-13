$(document).ready(function () {
    changeShowGallery();
    loadTableData();
});

function loadTableData() {
    $('.param-datatables').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: base_url + '/admin/param/load-table-data',
            dataType: "json",
            type: 'POST'
        },
        "columns": [
            { 'data': 'id', 'className': 'text-center' },
            { 'data': 'name', 'className': 'text-center' },
            { 'data': 'showOnGallery', 'className': 'text-center' },
            { 'data': 'user', 'className': 'text-center' },
            { 'data': 'last_update', 'className': 'text-center' }
        ]
    });
}

function changeShowGallery() {
    $('#table-view').off('click', '.change-show-gallery').on('click', '.change-show-gallery', function (e) {
        e.preventDefault();

        var id = $(this).data('id');
        var btn = $(this);
        
        $.ajax({
            url: base_url + '/admin/param/change-show-on-gallery',
            method: 'POST',
            data: {
                'id': id
            }
        })
        .done(function (data) {
            if (data.result) {
                if (data.status) {
                    btn.html('<i class="fas fa-check-circle text-success"></i>');
                } else {
                    btn.html('<i class="fas fa-times-circle text-danger"></i>');
                }
                
                BootstrapDialog.show({
                    'title': 'Update Gallery status',
                    'message': 'Update Gallery status successfully',
                    'type': BootstrapDialog.TYPE_SUCCESS
                });
            } else {
                BootstrapDialog.show({
                    'title': 'Update Gallery status',
                    'message': data.error,
                    'type': BootstrapDialog.TYPE_WARNING
                });
            }
        })
        .fail(function (xhr, status, error) {
            console.log(this.url);
            console.log(error);
        });
    });
}