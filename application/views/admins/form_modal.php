<!-- Add/Edit Admin Modal -->
<div class="modal fade" id="adminModal" tabindex="-1" aria-labelledby="adminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminModalLabel">Add New Admin</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="adminForm" method="post">
                <div class="modal-body">
                    <input type="hidden" id="adminId" name="id">
                    <div class="row">
                        <!-- Full Name -->
                        <div class="col-md-6 mb-4">
                            <div class="form-outline">
                                <input type="text" id="fullName" name="full_name" class="form-control" required />
                                <label class="form-label" for="fullName">Full Name</label>
                            </div>
                        </div>
                        <!-- Email -->
                        <div class="col-md-6 mb-4">
                            <div class="form-outline">
                                <input type="email" id="email" name="email" class="form-control" required />
                                <label class="form-label" for="email">Email</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Contact Number -->
                        <div class="col-md-6 mb-4">
                            <div class="form-outline">
                                <input type="tel" id="contactNumber" name="contact_number" class="form-control" required />
                                <label class="form-label" for="contactNumber">Contact Number</label>
                            </div>
                        </div>
                        <!-- Store Name -->
                        <div class="col-md-6 mb-4">
                            <div class="form-outline">
                                <input type="text" id="storeName" name="store_name" class="form-control" />
                                <label class="form-label" for="storeName">Store Name</label>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <!-- State Dropdown -->
                        <div class="col-md-6 mb-4">
                            <select id="state" name="state" class="form-select" required>
                                <option value="" disabled selected>Select State</option>
                                <?php foreach ($states as $state): ?>
                                    <option value="<?php echo $state->id; ?>"><?php echo htmlspecialchars($state->name); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- City Dropdown -->
                        <div class="col-md-6 mb-4">
                            <select id="city" name="city" class="form-select" required disabled>
                                <option value="" disabled selected>Select City</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <!-- GST Number -->
                        <div class="col-md-6 mb-4">
                            <div class="form-outline">
                                <input type="text" id="gstNumber" name="gst_number" class="form-control" />
                                <label class="form-label" for="gstNumber">GST Number</label>
                            </div>
                        </div>
                        <!-- Pincode -->
                        <div class="col-md-6 mb-4">
                            <div class="form-outline">
                                <input type="text" id="pincode" name="pincode" class="form-control" />
                                <label class="form-label" for="pincode">Pincode</label>
                            </div>
                        </div>
                    </div>
                    <!-- Address -->
                    <div class="form-outline mb-4">
                        <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                        <label class="form-label" for="address">Address</label>
                    </div>
                    <!-- Password -->
                    <div class="form-outline mb-4">
                        <input type="password" id="password" name="password" class="form-control" />
                        <label class="form-label" for="password">Password (leave blank to keep current)</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
