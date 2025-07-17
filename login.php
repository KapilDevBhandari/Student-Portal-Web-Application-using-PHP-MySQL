<?php
session_start();
require_once 'config.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    if ($email && $password) {
        $stmt = $pdo->prepare('SELECT * FROM students WHERE email = ? AND password = ?');
        $stmt->execute([$email, $password]);
        $student = $stmt->fetch();
        if ($student) {
            $_SESSION['student_id'] = $student['id'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Invalid email or password.';
        }
    } else {
        $error = 'Please enter both email and password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <nav>
        <div class="logo"><strong>Student Portal</strong></div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
            <a href="dashboard.php">Dashboard</a>
        </div>
    </nav>
    <div class="container">
        <h1>Login</h1>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" autocomplete="off">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        
        <div class="register-section">
            <hr>
            <p>Don't have an account?</p>
            <a href="register.php" class="register-btn">Create New Account</a>
        </div>
    </div>
    <footer>
        &copy; <?php echo date('Y'); ?> Kapil Dev Bhandari. All rights reserved.
    </footer>
</body>
</html> 