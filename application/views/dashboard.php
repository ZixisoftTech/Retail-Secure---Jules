<!-- Font Awesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --card-bg: #ffffff;
        --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        --icon-bg-blue: #e7f0ff;
        --icon-color-blue: #0d6efd;
        --icon-bg-green: #eaf6f0;
        --icon-color-green: #198754;
        --icon-bg-orange: #fff4e6;
        --icon-color-orange: #fd7e14;
        --icon-bg-purple: #f3e7ff;
        --icon-color-purple: #6f42c1;
    }
    .stat-card {
        background-color: var(--card-bg);
        border: none;
        border-radius: 12px;
        box-shadow: var(--card-shadow);
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }
    .stat-card .card-body {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .stat-card .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .stat-card .stat-info h5 {
        font-size: 1rem;
        color: #6c757d;
        margin-bottom: 5px;
    }
    .stat-card .stat-info h3 {
        font-size: 2.2rem;
        font-weight: 600;
        color: #343a40;
    }
</style>

<h1 class="mt-4 mb-4"><?php echo $title; ?></h1>

<div class="row g-4">
    <!-- Admins Card -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="card-body">
                <div class="stat-info">
                    <h5>Admins</h5>
                    <h3><?php echo $stats['admins']; ?></h3>
                </div>
                <div class="stat-icon" style="background-color: var(--icon-bg-blue); color: var(--icon-color-blue);">
                    <i class="fas fa-user-shield"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Super Stockists Card -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="card-body">
                <div class="stat-info">
                    <h5>Super Stockists</h5>
                    <h3><?php echo $stats['super_stockists']; ?></h3>
                </div>
                <div class="stat-icon" style="background-color: var(--icon-bg-green); color: var(--icon-color-green);">
                    <i class="fas fa-user-tie"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Distributors Card -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="card-body">
                <div class="stat-info">
                    <h5>Distributors</h5>
                    <h3><?php echo $stats['distributors']; ?></h3>
                </div>
                <div class="stat-icon" style="background-color: var(--icon-bg-orange); color: var(--icon-color-orange);">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Retailers Card -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="card-body">
                <div class="stat-info">
                    <h5>Retailers</h5>
                    <h3><?php echo $stats['retailers']; ?></h3>
                </div>
                <div class="stat-icon" style="background-color: var(--icon-bg-purple); color: var(--icon-color-purple);">
                    <i class="fas fa-store"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Other Placeholders -->
    <!-- You can add more cards here for packages, active devices, etc. -->
</div>
