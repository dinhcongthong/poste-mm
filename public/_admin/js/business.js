$(document).ready(function() {
    
    loadDataTable();

    $('.datatables').DataTable({
        "order": [[0, 'desc']]
    })

    $('#user-list-modal').on('show.bs.modal', function(e) {
        var btn = e.relatedTarget;
        var modal = $(this);

        var business_id = $(btn).data('id');
        console.log(business_id);

        $('#user-list-modal').off('click').on('click', '.set-owner', function() {
            var owner_id = $(this).data('owner');
            console.log(owner_id);

            $.ajax({
                url: base_url + '/admin/business/set-owner',
                method: 'POST',
                data: {
                    'business_id': business_id,
                    'owner_id': owner_id
                }
            })
            .done(function(data) {
                console.log(data);
                if(data.result) {
                    $('#table-view').html(data.view);

                    $('#business-list').DataTable().destroy();

                    $('#business-list').DataTable({
                        "order": [[0, 'desc']]
                    });

                    modal.modal('hide');
                }
            })
            .fail(function(xhr, status, error) {
                console.log(this.url);
                console.log(error);
                console.log(xhr.responseText);
            });
        });
    });

    $('#table-view').on('click', '.btn-status', function() {
        var id = $(this).data('id');
        var btn = $(this);

        $.ajax({
            url: base_url + '/admin/business/change-status',
            data: {
                'business_id': id
            },
            method: 'POST'
        })
        .done(function(data) {
            console.log(data);
            if(data.result) {
                if(data.status) {
                    btn.text('Normal').addClass('btn-success').removeClass('btn-danger');
                } else {
                    btn.text('Pending').addClass('btn-danger').removeClass('btn-success');
                }

                BootstrapDialog.show({
                    title: 'Change Status Business Article',
                    message: 'Update Status Business Article Successfully',
                    type: BootstrapDialog.TYPE_SUCCESS
                });
            } else {
                BootstrapDialog.show({
                    title: 'Change Status Business Article',
                    message: 'Update Status Business Article Fail',
                    type: BootstrapDialog.TYPE_WARNING
                });
            }
        })
        .fail(function(xhr, status, error) {
            console.log(this.url);
            console.log(error);
            console.log(xhr.responseText);
        });
    });

    /* Edit Info */
    $('select[name="type"]').on('change', function() {
        if($(this).val() == 0) {
            $('#end-free-date-form').removeClass('d-none');
            $('#start-date-form').addClass('d-none');
            $('#end-date-form').addClass('d-none');
        } else {
            $('#end-free-date-form').addClass('d-none');
            $('#start-date-form').removeClass('d-none');
            $('#end-date-form').removeClass('d-none');
        }
    });

    // Delete ARticle
    $('#table-view').on('click', '.btn-delete', function(e) {
        e.preventDefault();

        var id = $(this).data("id");
        BootstrapDialog.confirm({
            title: 'Delete Business',
            message: 'Do you really want to delete selected item? <br/>You can not restore after confirm it...',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function(result) {
                if(result) {
                    $.ajax({
                        url: base_url + '/account-setting/business/delete',
                        method: 'POST',
                        data: {
                            id: id,
                            page_type: 'admin'
                        }
                    })
                    .done(function(data) {
                        if(data.result) {
                            $('#table-view').html(data.view);

                            $('.datatables').DataTable().destroy();

                            $('.datatables').DataTable({
                                "order": [[0, 'desc']]
                            });

                            BootstrapDialog.show({
                                title: 'Delete Business Article',
                                message: 'Delete a business article Successfully',
                                type: BootstrapDialog.TYPE_SUCCESS
                            });
                        } else {
                            BootstrapDialog.show({
                                title: 'Delete Business Article',
                                message: 'Delete a business article failed...',
                                type: BootstrapDialog.TYPE_WARNING
                            });
                        }
                    })
                    .fail(function(xhr, status, error) {
                        BootstrapDialog.show({
                            title: 'Delete Business Article',
                            message: 'Delete a business article failed...',
                            type: BootstrapDialog.TYPE_WARNING
                        });
                        console.log(this.url);
                        console.log(error);
                        console.log(xhr.responseText);
                    });
                }
            }
        });
    })
});


function loadDataTable() {
    $('.business-datatables').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: base_url + '/admin/business/load-data-table',
            dataType: "json",
            type: 'POST'
        },
        "columns": [
            { "data": 'id', 'className': 'text-center' },
            { 'data': 'name' },
            { 'data': 'user', 'className': 'text-center' },
            { 'data': 'owner', 'className': 'text-center' },
            { 'data': 'info' },
            { 'data': 'status', 'className': 'text-center' },
            { 'data': 'action', 'className': 'text-center' }
        ]
    });
}
