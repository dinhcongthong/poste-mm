$(document).ready(function() {
    
    loadDataTable();

    // define global variable
    var town_id = 0;

    changeStatus();

    $('#town-list').DataTable();
    $('#user-list').DataTable();
    $('#promotion-list').DataTable();

    // Delete article
    $('#table-view').on('click', '.btn-delete', function(e) {
        e.preventDefault();

        var id = $(this).data("id");
        BootstrapDialog.confirm({
            title: 'Delete Town',
            message: 'Do you really want to delete selected item? <br/>You can not restore after confirm it...',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function(result) {
                if(result) {
                    $.ajax({
                        url: base_url + '/account-setting/town/delete',
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
                                title: 'Delete Town Article',
                                message: 'Delete a town article Successfully',
                                type: BootstrapDialog.TYPE_SUCCESS
                            });
                        } else {
                            BootstrapDialog.show({
                                title: 'Delete Town Article',
                                message: 'Delete a town article failed...',
                                type: BootstrapDialog.TYPE_WARNING
                            });
                        }
                    })
                    .fail(function(xhr, status, error) {
                        BootstrapDialog.show({
                            title: 'Delete Town Article',
                            message: 'Delete a town article failed...',
                            type: BootstrapDialog.TYPE_WARNING
                        });
                        console.log(this.url);
                        console.log(error);
                        console.log(xhr.responseText);
                    });
                }
            }
        });
    });
    // End Delete article

    $('#user-list-modal').on('show.bs.modal', function(e) {
        var btn = e.relatedTarget;
        var modal = $(this);

        town_id = $(btn).data('id');

        $('#user-list-modal').off('click').on('click', '.set-owner', function() {
            var owner_id = $(this).data('owner');

            $.ajax({
                url: base_url + '/admin/poste-town/set-owner',
                method: 'POST',
                data: {
                    'town_id': town_id,
                    'owner_id': owner_id
                }
            })
            .done(function(data) {
                if(data.result) {
                    $('#table-view').html(data.view);

                    $('#town-list').DataTable().destroy();

                    $('#town-list').DataTable({
                        "order": [[0, 'desc']]
                    });

                    changeStatus();

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

    $('#table-view').on('click', '.btn-remove-owner', function(e) {
        e.preventDefault();

        var btn = $(this);
        var town_id = btn.data('id');

        BootstrapDialog.confirm({
            title: 'Remove Owner for Selected Poste Town Article',
            message: 'Do you really want to remove owner???',
            type: BootstrapDialog.TYPE_DANGER,
            callback: function(result) {
                if(result) {
                    $.ajax({
                        url: base_url + '/admin/poste-town/remove-owner',
                        data: {
                            'town_id': town_id
                        },
                        method: 'POST'
                    })
                    .done(function(data) {
                        if(data.result) {
                            $('#table-view').html(data.view);

                            $('#town-list').DataTable().destroy();

                            $('#town-list').DataTable({
                                "order": [[0, 'desc']]
                            });

                            changeStatus();
                        }
                    })
                    .fail(function(xhr, status, error) {
                        console.log(this.url);
                        console.log(error);
                        console.log(xhr.responseText);
                    });
                }
            }
        });
    });

    $('#promotion-list-modal').on('show.bs.modal', function(e) {
        var btn = e.relatedTarget;
        var modal = $(this);

        town_id = $(btn).data('id');

        $('#promotion-list-modal').off('click').on('click', '.set-customer', function() {
            var customer_id = $(this).data('customer');

            $.ajax({
                url: base_url + '/admin/poste-town/set-customer',
                method: 'POST',
                data: {
                    'town_id': town_id,
                    'customer_id': customer_id
                }
            })
            .done(function(data) {
                if(data.result) {
                    $('#table-view').html(data.view);

                    $('#town-list').DataTable().destroy();

                    $('#town-list').DataTable({
                        "order": [[0, 'desc']]
                    });

                    modal.modal('hide');

                    changeStatus();
                }
            })
            .fail(function(xhr, status, error) {
                console.log(this.url);
                console.log(error);
                console.log(xhr.responseText);
            });
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
});

function changeStatus() {
    $('#table-view').on('click', '.btn-status', function() {
        var id = $(this).data('id');
        var type = $(this).data('type');
        var aTag = $(this);

        if(type == 'restore') {
            BootstrapDialog.confirm({
                title: 'Restore an Article',
                message: 'This article was deleted by their owner. Do you really want to restart it?',
                type: BootstrapDialog.TYPE_DANGER,
                callback: function(result) {
                    if(result) {
                        submitStatus(id);
                    }
                }
            })
        } else {
            submitStatus(id, aTag);
        }
    });
}

function submitStatus(id, tag) {
    $.ajax({
        url: base_url + '/admin/poste-town/change-status',
        data: {
            'id': id
        },
        type: 'POST'
    })
    .done(function(data) {
        if(data.result) {
            BootstrapDialog.show({
                title: 'Change Status Article',
                message: 'Change Status Success',
                type: BootstrapDialog.TYPE_SUCCESS
            });

            if(data.check) {
                if (data.status == 1) {
                    tag.text('Normal').removeClass('btn-secondary').removeClass('btn-warning').removeClass('btn-danger').addClass('btn-success');
                } else if (data.status == 2) {
                    tag.text('Temporay Closed').addClass('btn-secondary').removeClass('btn-warning').removeClass('btn-danger').removeClass('btn-success');
                } else {
                    tag.text('Official Closed').removeClass('btn-secondary').addClass('btn-warning').removeClass('btn-danger').removeClass('btn-success');
                }
            } else {
                tag.text('Pending').removeClass('btn-secondary').removeClass('btn-warning').addClass('btn-danger').removeClass('btn-success');
            }
        } else {
            BootstrapDialog.show({
                title: 'Change Status Article',
                message: data.error,
                type: BootstrapDialog.TYPE_WARNING
            });
        }
    })
    .fail(function(xhr, status, error) {
        console.log(this.url);
        console.log(error);
        console.log(xhr.responseText);
    });
}

function loadDataTable() {
    $('.poste_town_datatables').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: base_url + '/admin/poste-town/load-data-table',
            dataType: "json",
            type: 'POST'
        },
        "columns": [
            { "data": 'id', 'className': 'text-center' },
            { 'data': 'name' },
            { 'data': 'category', 'className': 'text-center' },
            { 'data': 'owner', 'className': 'text-center' },
            { 'data': 'promotion-owner', 'className': 'text-center' },
            { 'data': 'info' },
            { 'data': 'status', 'className': 'text-center' },
            { 'data': 'action', 'className': 'text-center' }
        ]
    });
}

