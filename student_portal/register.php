<?php
session_start();
require_once 'config.php';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $course = trim($_POST['course'] ?? '');
    
    if (empty($full_name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'All fields are required.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long.';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM students WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'Email already exists. Please use a different email.';
        } else {
            $stmt = $pdo->prepare('INSERT INTO students (full_name, email, password, phone, course) VALUES (?, ?, ?, ?, ?)');
            if ($stmt->execute([$full_name, $email, $password, $phone, $course])) {
                $success = 'Account created successfully! You can now login.';
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - Register</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <nav>
        <div class="logo"><strong>Student Portal</strong></div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        </div>
    </nav>
    <div class="container">
        <h1>Create Account</h1>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <form method="post" autocomplete="off">
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>" required>
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            
            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" required>
            
            <label for="course">Course</label>
            <input type="text" id="course" name="course" value="<?= htmlspecialchars($_POST['course'] ?? '') ?>" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            
            <button type="submit">Create Account</button>
        </form>
        
        <div class="login-section">
            <hr>
            <p>Already have an account?</p>
            <a href="login.php" class="login-btn">Login Here</a>
        </div>
    </div>
    <footer>
        &copy; <?php echo date('Y'); ?> Kapil Dev Bhandari. All rights reserved.
    </footer>
</body>
</html> 