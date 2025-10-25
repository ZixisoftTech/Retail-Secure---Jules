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
                            <span class="badge <?php echo $admin->status === 'active' ? 'badge-success' : 'badge-danger'; ?>">
                                <?php echo ucfirst($admin->status); ?>
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info edit-btn" data-id="<?php echo $admin->id; ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a href="<?php echo base_url('admins/delete/' . $admin->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this admin?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $this->load->view('admins/form_modal'); ?>

<!-- MDBootstrap JS for DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- Custom JS for this page -->
<script src="<?php echo base_url('assets/js/admins.js'); ?>"></script>
