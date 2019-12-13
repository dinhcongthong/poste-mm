$(document).ready(function() {
    changeStatus();

    loadDataTable();
    
    /* $('.btn-inform').on('click', function() {
        var id = $(this).data('id');
        var btn = $(this);
        
        $.ajax({
            method: 'POST',
            url: base_url + '/admin/ads/update-inform',
            data: {
                'id': id
            }
        })
        .done(function(data) {
            console.log(data);
            if(data.result) {
                
                if(data.status) {
                    btn.removeClass('btn-danger').addClass('btn-success').text('Informing');
                } else {
                    btn.removeClass('btn-success').addClass('btn-danger').text('Expired');
                }
                
                BootstrapDialog.show({
                    'title': 'Update Ad\'s Inform Sale',
                    'message': 'Update Inform Sale successfully',
                    'type': BootstrapDialog.TYPE_SUCCESS
                });
                
            } else {
                BootstrapDialog.show({
                    'title': 'Update Ad\'s Inform Sale',
                    'message': data.error,
                    'type': BootstrapDialog.TYPE_WARNING
                });
            }
        })
        .fail(function(xhr, status, error) {
            console.log(this.url);
            console.log(error);
        })
    }); */
    /* End Index Js */
    
    /* Update Js */
    $('#end-date').datetimepicker({
        format: 'MM-DD-YYYY',
        minDate: moment($('#start-date').val(), 'MM-DD-YYYY')
    });
    
    if($('textarea#note').length) {
        CKEDITOR.replace('note', {
            toolbar: 'Basic'
        });
    }
    /* End Update Js */
});

function changeStatus() {
    /* Index Js */
    $('#table-view').off('click', '.change-status').on('click', '.change-status', function (e) {
        e.preventDefault();
        
        var id = $(this).data('id');
        var aTag = $(this);
        
        $.ajax({
            url: base_url + '/admin/ads/change-status',
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
                    'title': 'Update Ad\'s status',
                    'message': 'Update status successfully',
                    'type': BootstrapDialog.TYPE_SUCCESS
                });
            } else {
                BootstrapDialog.show({
                    'title': 'Update Ad\'s satus',
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

function loadDataTable() {
    $('.ads-datatables').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: base_url + '/admin/ads/load-data-table',
            dataType: "json",
            type: 'POST'
        },
        "columns": [
            { "data": 'id', 'className': 'text-center' },
            { 'data': 'name' },
            { 'data': 'position' },
            { 'data': 'user' },
            { 'data': 'status', 'className': 'text-center' },
            { 'data': 'inform-sale', 'className': 'text-center' },
            { 'data': 'updated-at', 'className': 'text-center' },
            { 'data': 'action', 'className': 'text-center' }
        ]
    });
}