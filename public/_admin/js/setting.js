$(document).ready(function() {
    deleteSetting();
    loadTableData();
});

function loadTableData () {
    $('.setting-datatables').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: base_url + '/admin/setting/load-table-data',
            dataType: "json",
            type: 'POST'
        },
        "columns": [
            { 'data': 'id', 'className': 'text-center' },
            { 'data': 'name' },
            { 'data': 'value' },
            { 'data': 'tag', 'className': 'text-center' },
            { 'data': 'user', 'className': 'text-center' },
            { 'data': 'last_update', 'className': 'text-center' },
            { 'data': 'action', 'className': 'text-center' }
        ]
    });
}

function deleteSetting() {
    $('#table-view').off('click', '.btn-delete').on('click', '.btn-delete', function (e) {
        e.preventDefault();
        
        var id = $(this).data('id');
        var btn = $(this);
        
        BootstrapDialog.confirm({
            title: 'Delete a Setting',
            message: 'Do you really want to delete selected setting?',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function (result) {
                if (result) {
                    $.ajax({
                        url: base_url + '/admin/setting/delete',
                        method: 'POST',
                        data: {
                            'id': id
                        }
                    })
                    .done(function (data) {
                        if (data.result) {
                            $('#table-view').html(data.view);
                            
                            
                            $('.datatables').DataTable().destroy();
                            
                            loadTableData();
                            deleteSetting();
                            
                            MyBootstrapShow('Delete a Setting', 'Delete Successfully', 'success');
                        } else {
                            MyBootstrapShow('Delete a Setting', data.error, 'danger');
                        }
                    })
                    .fail(function (xhr, status, error) {
                        console.log(this.url);
                        console.log(error);
                        console.log(xhr.responseText);
                    });
                }
            }
        });
    });
}