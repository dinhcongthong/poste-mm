$(document).ready(function () {
    loadDataTable();

    $('#table-view').on('click', '.delete-btn', function (e) {
        e.preventDefault();

        var id = $(this).data('id');

        BootstrapDialog.confirm({
            title: 'Delete an item in SEO Meta',
            message: 'Do you really want to delete an item in SEO Meta Page',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function (result) {
                if (result) {
                    $.ajax({
                        url: base_url + '/admin/seo-meta/delete',
                        data: {
                            'id': id
                        },
                        method: 'POST',
                    })
                    .done(function (data) {
                        if (data.result) {
                            $('.datatables').DataTable().destroy();
                            loadDataTable();

                            BootstrapDialog.show({
                                title: 'Delete an item in SEO Meta',
                                message: 'Delete successfully',
                                type: BootstrapDialog.TYPE_SUCCESS
                            });
                        } else {
                            BootstrapDialog.show({
                                title: 'Delete an item in SEO Meta',
                                message: 'Delete failed',
                                type: BootstrapDialog.TYPE_SUCCESS
                            });
                        }
                    })
                    .fail(function (xhr, status, error) {
                        console.log(this.url);
                        console.log(error);
                        console.log(xhr.responseText);

                        BootstrapDialog.show({
                            title: 'Delete an item in SEO Meta',
                            message: 'Delete failed',
                            type: BootstrapDialog.TYPE_SUCCESS
                        });
                    });
                }
            }
        })
    });
});

function loadDataTable() {
    $('.datatables').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: base_url + '/admin/seo-meta/load-data-table',
            dataType: "json",
            type: 'POST'
        },
        "columns": [
            { "data": 'id', 'className': 'text-center' },
            { 'data': 'url' },
            { 'data': 'info', 'className': 'text-center', 'orderable': false },
            { 'data': 'action', 'className': 'text-center', 'orderable': false }
        ],
        "order": [[0, "DESC"]]
    });
}
