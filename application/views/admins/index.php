<!-- MDBootstrap CSS for DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />

<h1 class="mt-4 mb-4"><?php echo $title; ?></h1>

<!-- Display success/error messages -->
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success'); ?></div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger" role="alert"><?php echo $this->session->flashdata('error'); ?></div>
<?php endif; ?>


<div class="card shadow-sm mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Admins</h5>
        <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#adminModal">
            <i class="fas fa-plus me-2"></i>Add New Admin
        </button>
    </div>
    <div class="card-body">
        <table id="adminsTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Contact Number</th>
                    <th>Store Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($admins as $admin): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($admin->full_name); ?></td>
                        <td><?php echo htmlspecialchars($admin->email); ?></td>
                        <td><?php echo htmlspecialchars($admin->contact_number); ?></td>
                        <td><?php echo htmlspecialchars($admin->store_name); ?></td>
                        <td>
                            <span class="badge <?php echo $admin->status === 'active' ? 'bg-success' : 'bg-danger'; ?>">
                                <?php echo ucfirst($admin->status); ?>
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info edit-btn" data-id="<?php echo $admin->id; ?>">Edit</button>
                            <a href="<?php echo base_url('admins/delete/' . $admin->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<!-- MDBootstrap JS for DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<?php $this->load->view('admins/form_modal'); ?>

<script>
    $(document).ready(function() {
        $('#adminsTable').DataTable();

        // Reset form and change title for adding a new admin
        $('button[data-mdb-target="#adminModal"]').on('click', function() {
            $('#adminModalLabel').text('Add New Admin');
            $('#adminForm').attr('action', '<?php echo base_url('admins/add'); ?>');
            $('#adminForm')[0].reset();
            $('#adminId').val('');
            $('#password').parent().show(); // Show password field for new user
        });

        // Fetch data and populate form for editing an admin
        $('.edit-btn').on('click', function() {
            var adminId = $(this).data('id');

            // Fetch admin data via AJAX
            $.ajax({
                url: '<?php echo base_url('admins/get_admin/'); ?>' + adminId,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#adminModalLabel').text('Edit Admin');
                    $('#adminForm').attr('action', '<?php echo base_url('admins/edit/'); ?>' + adminId);

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
                    if (data.status === 'active') {
                        $('#status').prop('checked', true);
                    } else {
                        $('#status').prop('checked', false);
                    }

                    $('#password').parent().hide(); // Hide password field on edit

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
</script>
