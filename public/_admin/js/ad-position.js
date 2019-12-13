$(document).ready(function() {
    eventChange();
    loadDataTable();
});

function loadDataTable() {

    $('.ads-position-datatables').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: base_url + '/admin/ads/position/load-data-table-position',
            dataType: "json",
            type: 'POST',
        },
        "columns": [
            { "data": 'id' },
            { 'data': 'position' },
            { 'data': 'arrangement' },
            { 'data': 'version-show' },
            { 'data': 'user' },
            { 'data': 'updated-at', 'className': 'text-center' },
            { 'data': 'action', 'className': 'text-center' }
        ]
    });
}

function eventChange() {
    $('#table-view').off('change', '.sl-how-to-show').on('change', '.sl-how-to-show', function () {
        var howToShowId = $(this).val();
        var id = $(this).data('id');
        
        $.ajax({
            url: base_url + '/admin/ads/position/change-how-to-show',
            method: 'POST',
            data: {
                'id': id,
                'howToShowId': howToShowId
            }
        })
        .done(function (data) {
            if (data.result) {
                BootstrapDialog.show({
                    'title': 'Update How To Show',
                    'message': 'Update How To Show successfully',
                    'type': BootstrapDialog.TYPE_SUCCESS
                });
            } else {
                BootstrapDialog.show({
                    'title': 'Update How To Show',
                    'message': data.message,
                    'type': BootstrapDialog.TYPE_WARNING
                });
            }
        })
        .fail(function (xhr, status, error) {
            console.log(this.url);
            console.log(error);
        });
        
    });
    
    $('#table-view').off('change', '.sl-version-show').on('change', '.sl-version-show', function () {
        var versionId = $(this).val();
        var id = $(this).data('id');
        
        $.ajax({
            url: base_url + '/admin/ads/position/change-version-show',
            method: 'POST',
            data: {
                'id': id,
                'versionId': versionId
            }
        })
        .done(function (data) {
            if (data.result) {
                BootstrapDialog.show({
                    'title': 'Update Version Show',
                    'message': 'Update Version Show successfully',
                    'type': BootstrapDialog.TYPE_SUCCESS
                });
            } else {
                BootstrapDialog.show({
                    'title': 'Update Version Show',
                    'message': data.message,
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