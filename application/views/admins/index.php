<!-- MDBootstrap CSS for DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" />

<h1 class="mt-4 mb-4"><?php echo $title; ?></h1>

<!-- Display success/error messages -->
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success'); ?></div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger" role="alert"><?php echo $this->session->flashdata('error'); ?></div>
<?php endif; ?>

<div class="card shadow-lg mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-primary fw-bold">All Admins</h5>
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
                    <th>Contact</th>
                    <th>Store Name</th>
                    <th>Wallet Balance</th>
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
                        <td>₹<?php echo number_format($admin->wallet_balance, 2); ?></td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input status-toggle" type="checkbox" role="switch" id="statusSwitch-<?php echo $admin->id; ?>"
                                       data-id="<?php echo $admin->id; ?>"
                                       data-status="<?php echo $admin->status; ?>"
                                       <?php echo $admin->status === 'active' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="statusSwitch-<?php echo $admin->id; ?>"><?php echo ucfirst($admin->status); ?></label>
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info edit-btn" data-id="<?php echo $admin->id; ?>" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-success wallet-btn" data-id="<?php echo $admin->id; ?>" title="Manage Wallet">
                                <i class="fas fa-wallet"></i>
                            </button>
                            <a href="<?php echo base_url('admins/delete/' . $admin->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this admin?')" title="Delete">
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
<?php $this->load->view('admins/wallet_modal'); ?>
