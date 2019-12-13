$(document).ready(function() {
    /* Update */
    changeStatus();
    loadTableData();
});

function loadTableData () {
    $('.city-datatables').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: base_url + '/admin/city/load-table-data',
            dataType: "json",
            type: 'POST'
        },
        "columns": [
            { 'data': 'id', 'className': 'text-center' },
            { 'data': 'name', 'className': 'text-center' },
            { 'data': 'user', 'className': 'text-center' },
            { 'data': 'status', 'className': 'text-center' }
        ]
    });
    
}

function changeStatus() {
    $('#table-view').off('click', '.change-status').on('click', '.change-status', function (e) {
        e.preventDefault();
        
        var btn = $(this);
        var id = $(this).data('id');
        console.log(id);
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
