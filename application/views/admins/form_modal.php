<!-- Add/Edit Admin Modal -->
<div class="modal fade" id="adminModal" tabindex="-1" aria-labelledby="adminModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="adminModalLabel">Add New Admin</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>

      <?php echo form_open('admins/add', ['id' => 'adminForm']); ?>
        <div class="modal-body">
            <input type="hidden" name="id" id="adminId">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="form-outline">
                        <input type="text" id="fullName" name="full_name" class="form-control" required />
                        <label class="form-label" for="fullName">Full Name</label>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="form-outline">
                        <input type="email" id="email" name="email" class="form-control" required />
                        <label class="form-label" for="email">Email ID</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="form-outline">
                        <input type="text" id="contactNumber" name="contact_number" class="form-control" required />
                        <label class="form-label" for="contactNumber">Contact Number</label>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="form-outline">
                        <input type="password" id="password" name="password" class="form-control" />
                        <label class="form-label" for="password">Password</label>
                        <small class="form-text text-muted">Leave blank to keep current password.</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="form-outline">
                        <input type="text" id="adminName" name="admin_name" class="form-control" />
                        <label class="form-label" for="adminName">Admin Name</label>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="form-outline">
                        <input type="text" id="storeName" name="store_name" class="form-control" />
                        <label class="form-label" for="storeName">Store Name</label>
                    </div>
                </div>
            </div>

            <div class="form-outline mb-4">
                <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                <label class="form-label" for="address">Address</label>
            </div>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="form-outline">
                        <input type="text" id="city" name="city" class="form-control" />
                        <label class="form-label" for="city">City</label>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="form-outline">
                        <input type="text" id="state" name="state" class="form-control" />
                        <label class="form-label" for="state">State</label>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="form-outline">
                        <input type="text" id="pincode" name="pincode" class="form-control" />
                        <label class="form-label" for="pincode">Pincode</label>
                    </div>
                </div>
            </div>

            <div class="form-outline mb-4">
                <input type="text" id="gstNumber" name="gst_number" class="form-control" />
                <label class="form-label" for="gstNumber">GST Number</label>
            </div>

            <div class="form-check form-switch mb-4">
              <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="active" checked />
              <label class="form-check-label" for="status">Active</label>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
