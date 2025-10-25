$(document).ready(function() {
    // Initialize DataTable
    $('#adminsTable').DataTable();

    // Reset form for adding a new admin
    $('button[data-mdb-toggle="modal"][data-mdb-target="#adminModal"]').on('click', function() {
        $('#adminModalLabel').text('Add New Admin');
        $('#adminForm').attr('action', baseUrl + 'admins/add');
        $('#adminForm')[0].reset();
        $('#adminId').val('');
        $('#password').closest('.form-outline').show(); // Show password field
        // Manually update MDB input labels
        $('#adminModal .form-outline').each(function() {
            new mdb.Input(this).update();
        });
    });

    // Fetch data and populate form for editing an admin
    $('#adminsTable').on('click', '.edit-btn', function() {
        var adminId = $(this).data('id');

        // Fetch admin data via AJAX
        $.ajax({
            url: baseUrl + 'admins/get_admin/' + adminId,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#adminModalLabel').text('Edit Admin');
                $('#adminForm').attr('action', baseUrl + 'admins/edit/' + adminId);

                // Populate form fields
                $('#adminId').val(data.id);
                $('#fullName').val(data.full_name);
                $('#email').val(data.email);
                $('#contactNumber').val(data.contact_number);
                $('#adminName').val(data.admin_name);
                $('#storeName').val(data.store_name);
                $('#address').val(data.address);
                $('#city').val(data.city);
                $('#state').val(data.state);
                $('#pincode').val(data.pincode);
                $('#gstNumber').val(data.gst_number);

                // Handle status switch
                $('#status').prop('checked', data.status === 'active');

                $('#password').closest('.form-outline').hide(); // Hide password field on edit

                // Re-initialize MDB inputs to show labels correctly
                $('#adminModal .form-outline').each(function() {
                    new mdb.Input(this).update();
                });

                // Show the modal
                var adminModal = new mdb.Modal(document.getElementById('adminModal'));
                adminModal.show();
            }
        });
    });
});
