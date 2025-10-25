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

    // Client-side form validation
    $('#adminForm').on('submit', function(e) {
        if (!validateAdminForm()) {
            e.preventDefault();
        }
    });

    function validateAdminForm() {
        var isValid = true;
        $('.invalid-feedback').text('');
        $('.is-invalid').removeClass('is-invalid');

        // Full Name
        if ($('#fullName').val().trim() === '') {
            showError('#fullName', 'Full Name is required.');
            isValid = false;
        }

        // Email
        var email = $('#email').val().trim();
        if (email === '') {
            showError('#email', 'Email is required.');
            isValid = false;
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            showError('#email', 'Please enter a valid email address.');
            isValid = false;
        }

        // Contact Number
        var contact = $('#contactNumber').val().trim();
        if (contact === '') {
            showError('#contactNumber', 'Contact Number is required.');
            isValid = false;
        } else if (!/^\d{10}$/.test(contact)) {
            showError('#contactNumber', 'Contact Number must be exactly 10 digits.');
            isValid = false;
        }

        // Store Name
        if ($('#storeName').val().trim() === '') {
            showError('#storeName', 'Store Name is required.');
            isValid = false;
        }

        // State
        if ($('#state').val() === null || $('#state').val() === '') {
            showError('#state', 'Please select a state.');
            isValid = false;
        }

        // City
        if ($('#city').val() === null || $('#city').val() === '') {
            showError('#city', 'Please select a city.');
            isValid = false;
        }

        // GST Number
        var gst = $('#gstNumber').val().trim();
        if (gst !== '' && !/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/.test(gst)) {
            showError('#gstNumber', 'Please enter a valid GST number.');
            isValid = false;
        }

        return isValid;
    }

    function showError(selector, message) {
        $(selector).addClass('is-invalid');
        $(selector).closest('.mb-4').find('.invalid-feedback').text(message);
    }

    // Function to get a fresh CSRF token
    function getCsrfToken(callback) {
        $.get(baseUrl + 'admins/get_csrf_token', function(token) {
            callback(token);
        }, 'json');
    }

    // Handle Status Toggle
    $('#adminsTable').on('change', '.status-toggle', function() {
        var self = this;
        var userId = $(self).data('id');
        var currentStatus = $(self).data('status');

        getCsrfToken(function(token) {
            var postData = {
                id: userId,
                status: currentStatus,
            };
            postData[token.name] = token.hash;

            $.ajax({
                url: baseUrl + 'admins/toggle_status',
                method: 'POST',
                data: postData,
                dataType: 'json',
                success: function(response) {
                    var label = $('label[for="statusSwitch-' + userId + '"]');
                    label.text(response.new_status.charAt(0).toUpperCase() + response.new_status.slice(1));
                    $(self).data('status', response.new_status);
                }
            });
        });
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

    // Handle Wallet Button Click (Re-written for new modal)
    $('#adminsTable').on('click', '.wallet-btn', function() {
        var adminId = $(this).data('id');
        $('#walletUserId').val(adminId);

        // Clear previous data and alerts
        $('#walletAlerts').html('');
        $('#parentBalance').text('');
        $('#walletForm')[0].reset();

        // Fetch user and parent details
        $.ajax({
            url: baseUrl + 'admins/get_admin/' + adminId,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#currentBalance').text('₹' + parseFloat(data.wallet_balance).toFixed(2));
                if(data.parent_name) {
                    $('#parentBalance').text('Parent: ' + data.parent_name + ' (Balance: ₹' + parseFloat(data.parent_wallet_balance).toFixed(2) + ')');
                }
            }
        });

        loadTransactionHistory(adminId);

        var walletModal = new mdb.Modal(document.getElementById('walletModal'));
        walletModal.show();
    });

    // Handle Wallet Form Submission (Re-written for AJAX)
    $('#walletForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);

        getCsrfToken(function(token) {
            // Add token to form data
            var formData = form.serialize() + '&' + token.name + '=' + token.hash;

            $.ajax({
                url: baseUrl + 'admins/manage_wallet',
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#walletAlerts').html('<div class="alert alert-success">Transaction Successful!</div>');
                        // Refresh history and balances
                        loadTransactionHistory($('#walletUserId').val());
                         $.ajax({
                            url: baseUrl + 'admins/get_admin/' + $('#walletUserId').val(),
                            method: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                $('#currentBalance').text('₹' + parseFloat(data.wallet_balance).toFixed(2));
                                if(data.parent_name) {
                                     $('#parentBalance').text('Parent: ' + data.parent_name + ' (Balance: ₹' + parseFloat(data.parent_wallet_balance).toFixed(2) + ')');
                                }
                            }
                        });
                        // Also, update the main datatable row without reload
                         var table = $('#adminsTable').DataTable();
                         var row = table.row( $('button[data-id="' + $('#walletUserId').val() + '"]').parents('tr') );
                         row.data()[4] = '₹' + parseFloat($('#currentBalance').text().replace('₹','')).toFixed(2); // Update wallet balance cell
                         table.draw(false);

                    } else {
                        $('#walletAlerts').html('<div class="alert alert-danger">' + response.error + '</div>');
                    }
                }
            });
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
