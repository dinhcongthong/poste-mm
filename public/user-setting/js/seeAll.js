$(document).ready(function(){
    loadDataTable();
    BusinesschangeStatus();
    TownchangeStatus();
});

// get data table
function loadDataTable() {
    $('.town-datatables').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: base_url + '/account-setting/town/load-data-table',
            dataType: "json",
            type: 'POST'
        },
        "columns": [
            { 'data': 'id', 'className': 'text-center' },
            { 'data': 'name', 'className': 'col text-truncate align-middle' },
            { 'data': 'expired_date', 'className': 'text-center align-middle' },
            { 'data': 'last_updated', 'className': 'text-center align-middle' },
            { 'data': 'status', 'className': 'text-center align-middle' },
            { 'data': 'edit', 'className': 'text-center align-middle' },
            { 'data': 'delete', 'className': 'col-auto text-center align-middle' }
        ]
    });
    // business datatables
    $('.business-datatables').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: base_url + '/account-setting/business/load-data-table',
            dataType: "json",
            type: 'POST'
        },
        "columns": [
            { 'data': 'id', 'className': 'text-center' },
            { 'data': 'name', 'className': 'col text-truncate align-middle' },
            { 'data': 'expired_date', 'className': 'text-center align-middle' },
            { 'data': 'last_updated', 'className': 'text-center align-middle' },
            { 'data': 'status', 'className': 'text-center align-middle' },
            { 'data': 'edit', 'className': 'text-center align-middle' },
            { 'data': 'delete', 'className': 'col-auto text-center align-middle' }
        ]
    });
    
}

// update status Town
function TownchangeStatus() {
    $('#table-view').off('click', '.town-change-status').on('click', '.town-change-status', function (e) {
        e.preventDefault();
        
        var id = $(this).data('id');
        var aTag = $(this);
        
        $.ajax({
            url: base_url + '/account-setting/town/change-status',
            method: 'POST',
            data: {
                'id': id
            }
        })
        .done(function (data) {
            console.log(data);
            console.log(aTag.data('id'));
            if (data.result) {
                if (data.status) {
                    aTag.html('<i class="fas fa-check-circle text-success" title="Activated"></i>');
                } else {
                    aTag.html('<i class="fas fa-times-circle text-danger" title="Pending"></i>');
                }
                BootstrapDialog.show({
                    'title': 'Update Poste Town Status',
                    'message': 'Update status successfully',
                    'type': BootstrapDialog.TYPE_SUCCESS
                });
            } else {
                BootstrapDialog.show({
                    'title': 'Update Poste Town satus',
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
// update status Business
function BusinesschangeStatus() {
    $('#table-view').off('click', '.business-change-status').on('click', '.business-change-status', function (e) {
        e.preventDefault();
        
        var id = $(this).data('id');
        var aTag = $(this);
        
        $.ajax({
            url: base_url + '/account-setting/business/change-status',
            method: 'POST',
            data: {
                'id': id
            }
        })
        .done(function (data) {
            if (data.result) {
                if (data.status) {
                    aTag.html('<i class="fas fa-check-circle text-success"></i>');
                } else {
                    aTag.html('<i class="fas fa-times-circle text-danger"></i>');
                }
                BootstrapDialog.show({
                    'title': 'Update Poste Business Status',
                    'message': 'Update status successfully',
                    'type': BootstrapDialog.TYPE_SUCCESS
                });
            } else {
                BootstrapDialog.show({
                    'title': 'Update Poste Business satus',
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
