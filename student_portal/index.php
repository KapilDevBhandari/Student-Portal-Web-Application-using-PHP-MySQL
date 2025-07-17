<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - Home</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav>
        <div class="logo"><strong>Student Portal</strong></div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
            <a href="login.php">Dashboard</a>
        </div>
    </nav>
    <div class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">Welcome to the Student Portal</h1>
            <p class="hero-subtitle">Your gateway to academic excellence and seamless student management</p>
            <div class="hero-buttons">
                <a href="login.php" class="btn btn-primary">Get Started</a>
                <a href="register.php" class="btn btn-secondary">Create Account</a>
            </div>
        </div>
        <div class="hero-image">
            <div class="floating-card">
                <div class="card-icon">🎓</div>
                <h3>Student Success</h3>
                <p>Track your academic journey</p>
            </div>
        </div>
    </div>

    <div class="features-section">
        <div class="container">
            <h2 class="section-title">Why Choose Our Portal?</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🔐</div>
                    <h3>Secure Login</h3>
                    <p>Your data is protected with industry-standard security measures</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">👤</div>
                    <h3>Profile Management</h3>
                    <p>Update your personal information and course details easily</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📱</div>
                    <h3>Modern Interface</h3>
                    <p>Clean, responsive design that works on all devices</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3>Fast & Reliable</h3>
                    <p>Quick access to your information whenever you need it</p>
                </div>
            </div>
        </div>
    </div>

    <div class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">1000+</div>
                    <div class="stat-label">Active Students</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Courses Available</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">99.9%</div>
                    <div class="stat-label">Uptime</div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        &copy; <?php echo date('Y'); ?> Kapil Dev Bhandari. All rights reserved.
    </footer>
</body>
</html> 