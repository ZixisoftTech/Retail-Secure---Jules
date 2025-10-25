$(document).ready(function() {
    // Initialize DataTable with Export Buttons
    $('#adminsTable').DataTable({
        "scrollX": true,
        "dom": 'Bfrtip',
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

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

    // Handle Wallet Button Click
    $('#adminsTable').on('click', '.wallet-btn', function() {
        var adminId = $(this).data('id');
        $('#walletUserId').val(adminId);

        // Fetch current balance and transaction history
        $.ajax({
            url: baseUrl + 'admins/get_admin/' + adminId,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#currentBalance').text('₹' + parseFloat(data.wallet_balance).toFixed(2));
            }
        });

        loadTransactionHistory(adminId);

        var walletModal = new mdb.Modal(document.getElementById('walletModal'));
        walletModal.show();
    });

    // Handle State Dropdown Change for Dynamic Cities
    $('#state').on('change', function() {
        var stateId = $(this).val();
        var citySelect = $('#city');

        citySelect.prop('disabled', true).html('<option value="" disabled selected>Loading...</option>');

        if (stateId) {
            $.ajax({
                url: baseUrl + 'admins/get_cities_by_state/' + stateId,
                method: 'GET',
                dataType: 'json',
                success: function(cities) {
                    citySelect.prop('disabled', false).html('<option value="" disabled selected>Select City</option>');
                    cities.forEach(function(city) {
                        citySelect.append($('<option>', {
                            value: city.id,
                            text: city.name
                        }));
                    });
                }
            });
        }
    });

    // Handle Wallet Form Submission
    $('#walletForm').on('submit', function(e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            url: baseUrl + 'admins/manage_wallet',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // On success, close modal and reload the page to see changes
                    var walletModal = mdb.Modal.getInstance(document.getElementById('walletModal'));
                    walletModal.hide();
                    location.reload();
                } else {
                    $('#walletAlerts').html('<div class="alert alert-danger">' + response.error + '</div>');
                }
            }
        });
    });

    function loadTransactionHistory(userId) {
        $.ajax({
            url: baseUrl + 'admins/get_wallet_transactions/' + userId,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var historyHtml = '';
                if (data.length > 0) {
                    data.forEach(function(tx) {
                        historyHtml += '<tr>' +
                            '<td>' + new Date(tx.created_at).toLocaleDateString() + '</td>' +
                            '<td>' + tx.transaction_type.charAt(0).toUpperCase() + tx.transaction_type.slice(1) + '</td>' +
                            '<td>₹' + parseFloat(tx.amount).toFixed(2) + '</td>' +
                            '<td>' + tx.remark + '</td>' +
                            '</tr>';
                    });
                } else {
                    historyHtml = '<tr><td colspan="4" class="text-center">No transactions found.</td></tr>';
                }
                $('#transactionHistoryBody').html(historyHtml);
            }
        });
    }
});
