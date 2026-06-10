<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #678cb0; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .login-card { max-width: 400px; width: 100%; }
    </style>
</head>
<body>

<div class="login-card card shadow">
    <div class="card-header bg-primary text-white text-center">
        <h4>🔐 Admin Login</h4>
    </div>
    <div class="card-body">
        <?php
        session_start();
        if (isset($_POST['login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Change these if you want
            if ($username === 'Strengthup' && $password === '12345') {
                $_SESSION['loggedin'] = true;
                header("Location: index.php");
                exit;
            } else {
                echo '<div class="alert alert-danger">❌ Wrong username or password!</div>';
            }
        }
        ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="login" class="btn btn-success w-100">Login</button>
        </form>
    </div>
    <div class="card-footer text-center text-muted">
        Default: admin / admin123
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>