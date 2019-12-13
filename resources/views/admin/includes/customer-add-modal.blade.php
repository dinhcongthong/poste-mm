{{-- Modal Add Customer --}}
<div class="modal fade" id="modalAddCustomer" tabindex="-1" role="dialog" aria-labelledby="modalAddCustomerTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="#" method="POST" id="modal-add-customer">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddCustomerTitle">Add New Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" value="" name="customer_name" required>
                    </div>
                    <div class="form-group">
                        <label>Owner Name</label>
                        <input type="text" class="form-control" value="" name="customer_owner_name" required>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" value="" name="customer_phone" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" value="" name="customer_email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('form#modal-add-customer').on('submit', function(e) {
            e.preventDefault();
            
            var form = $(this);
            $.ajax({
                url: base_url + '/admin/customer/ajax-add-customer',
                method: 'POST',
                data: form.serializeArray()
            })
            .done(function(data) {
                console.log(data);
                
                if(data.result) {
                    $('select#sl-choose-customer').html(data.html);
                    
                    $('select#sl-choose-customer').select2('destroy').select2();
                } else {
                    BootstrapDialog.show({
                        'title': 'Add New Customer',
                        'message': data.error,
                        'type': BootstrapDialog.TYPE_WARNING
                    });
                }
                
                $('#modalAddCustomer').modal('hide');
            })
            .fail(function(xhr, status, error) {
                console.log(this.url);
                console.log(error);
            });
        });
    });
</script>