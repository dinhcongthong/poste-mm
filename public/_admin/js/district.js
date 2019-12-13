$(document).ready(function() {
    /* Update */
    changeStatus();

    $('.datatables').DataTable({
        "order": [[0, 'desc']]
    }).on('draw', function () {
        changeStatus();
    });

});

function changeStatus() {
    $('.change-status').off('click').on('click', function (e) {
        e.preventDefault();

        var btn = $(this);
        var id = $(this).data('id');
        $.ajax({
            url: base_url + '/admin/city/change-status',
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
                    'title': 'Update User status',
                    'message': 'Update User status successfully',
                    'type': BootstrapDialog.TYPE_SUCCESS
                });
            } else {
                BootstrapDialog.show({
                    'title': 'Update User status',
                    'message': data.error,
                    'type': BootstrapDialog.TYPE_WARNING
                });
            }
        })
        .fail(function (xhr, status, error) {
            console.log(this.url);
            console.log(error);
            console.log(xhr.responseText);
        });
    });
}
