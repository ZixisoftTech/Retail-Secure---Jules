<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h1 class="text-primary fw-bold"><?php echo $title; ?></h1>
        <a href="<?php echo current_url(); ?>" class="btn btn-primary btn-lg"><i class="fas fa-sync-alt me-2"></i>Refresh</a>
    </div>

    <div class="row">
        <!-- Admins Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="<?php echo base_url('admins'); ?>" class="card-link">
                <div class="card bg-primary text-white shadow-lg h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h3 fw-bold"><?php echo $stats['total_admins']; ?></div>
                            <div class="text-uppercase small">Manage Admins</div>
                        </div>
                        <i class="fas fa-user-shield fa-3x opacity-50"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Super Stockists Card -->
        <div class="col-xl-3 col-md-6 mb-4">
             <a href="#" class="card-link">
                <div class="card bg-success text-white shadow-lg h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h3 fw-bold"><?php echo $stats['total_super_stockists']; ?></div>
                            <div class="text-uppercase small">Super Stockists</div>
                        </div>
                        <i class="fas fa-user-tie fa-3x opacity-50"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Distributors Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="#" class="card-link">
                <div class="card bg-info text-white shadow-lg h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h3 fw-bold"><?php echo $stats['total_distributors']; ?></div>
                            <div class="text-uppercase small">Distributors</div>
                        </div>
                        <i class="fas fa-users fa-3x opacity-50"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Retailers Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="#" class="card-link">
                <div class="card bg-warning text-white shadow-lg h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h3 fw-bold"><?php echo $stats['total_retailers']; ?></div>
                            <div class="text-uppercase small">Retailers</div>
                        </div>
                        <i class="fas fa-store fa-3x opacity-50"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Total Packages Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="#" class="card-link">
                <div class="card bg-danger text-white shadow-lg h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h3 fw-bold"><?php echo $stats['total_packages']; ?></div>
                            <div class="text-uppercase small">Total Packages</div>
                        </div>
                        <i class="fas fa-box-open fa-3x opacity-50"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Active Devices Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="#" class="card-link">
                <div class="card bg-secondary text-white shadow-lg h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h3 fw-bold"><?php echo $stats['active_device_users']; ?></div>
                            <div class="text-uppercase small">Active Devices</div>
                        </div>
                        <i class="fas fa-mobile-alt fa-3x opacity-50"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Today's Activations Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="#" class="card-link">
                <div class="card bg-dark text-white shadow-lg h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h3 fw-bold"><?php echo $stats['todays_activations']; ?></div>
                            <div class="text-uppercase small">Today's Activations</div>
                        </div>
                        <i class="fas fa-calendar-check fa-3x opacity-50"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
.card-link {
    text-decoration: none;
}
.card {
    transition: all 0.3s ease-in-out;
    border-radius: 1rem;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
}
</style>
