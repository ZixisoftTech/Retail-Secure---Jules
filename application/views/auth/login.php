<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0d6efd;
            --background-gradient-start: #f0f2f5;
            --background-gradient-end: #d6e4ff;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --input-border-color: #ced4da;
            --input-focus-border-color: #86b7fe;
        }

        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: linear-gradient(135deg, var(--background-gradient-start), var(--background-gradient-end));
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            border: none;
        }

        .login-card .logo {
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 25px;
        }

        .form-floating label {
            color: #6c757d;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid var(--input-border-color);
            transition: all 0.2s ease-in-out;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            border-color: var(--input-focus-border-color);
        }

        .btn-primary {
            font-weight: 500;
            padding: 12px;
            border-radius: 8px;
            transition: all 0.2s ease-in-out;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
        }

        .alert {
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="login-card text-center">
        <div class="logo">
            Welcome
        </div>
        <h1 class="h4 mb-4 fw-light">Sign in to your account</h1>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

        <?php echo form_open('auth/login'); ?>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                <label for="email">Email address</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign In</button>
        <?php echo form_close(); ?>

        <p class="mt-5 mb-3 text-muted">&copy; <?php echo date('Y'); ?></p>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
