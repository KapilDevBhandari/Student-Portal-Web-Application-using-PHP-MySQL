<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit;
}
require_once 'config.php';
$student_id = $_SESSION['student_id'];
$stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?');
$stmt->execute([$student_id]);
$student = $stmt->fetch();
if (!$student) {
    session_destroy();
    header('Location: login.php');
    exit;
}
$photo = 'https://ui-avatars.com/api/?name=' . urlencode($student['full_name'] ?? 'Student');

try {
    $check_photo = $pdo->query("SHOW COLUMNS FROM students LIKE 'photo'");
    if ($check_photo->rowCount() > 0 && isset($student['photo']) && $student['photo']) {
        $photo_path = 'uploads/' . $student['photo'];
        if (file_exists($photo_path)) {
            $photo = $photo_path;
        }
    }
} catch (PDOException $e) {
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <nav>
        <div class="logo"><strong>Student Portal</strong></div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="#" onclick="confirmLogout()">Logout</a>
        </div>
    </nav>
    <div class="container">
        <h1>Welcome, <?= htmlspecialchars($student['full_name']) ?></h1>
        
        <!-- User Details Section -->
        <div class="card" id="userDetails">
            <div class="profile-header">
                <img src="<?= htmlspecialchars($photo) ?>" alt="Profile Photo" class="profile-photo">
                <div class="profile-info">
                    <h2><?= htmlspecialchars($student['full_name']) ?></h2>
                    <p class="email"><?= htmlspecialchars($student['email']) ?></p>
                </div>
            </div>
            
            <div class="details-grid">
                <div class="detail-item">
                    <label>Full Name:</label>
                    <span><?= htmlspecialchars($student['full_name']) ?></span>
                </div>
                <div class="detail-item">
                    <label>Email:</label>
                    <span><?= htmlspecialchars($student['email']) ?></span>
                </div>
                <div class="detail-item">
                    <label>Phone Number:</label>
                    <span><?= htmlspecialchars($student['phone']) ?></span>
                </div>
                <div class="detail-item">
                    <label>Course:</label>
                    <span><?= htmlspecialchars($student['course']) ?></span>
                </div>
            </div>
            
            <div class="action-buttons">
                <button type="button" onclick="showEditForm()" class="edit-btn">Edit Profile</button>
                <button type="button" onclick="confirmDelete()" class="delete-btn">Delete Profile</button>
            </div>
        </div>
        
        <!-- Edit Profile Form (Hidden by default) -->
        <div class="card" id="editForm" style="display: none;">
            <h2>Edit Profile</h2>
            <form action="update_profile.php" method="post" enctype="multipart/form-data">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" value="<?= htmlspecialchars($student['full_name']) ?>" required>
                
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" readonly>
                
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($student['phone']) ?>" required>
                
                <label for="course">Course</label>
                <input type="text" id="course" name="course" value="<?= htmlspecialchars($student['course']) ?>" required>
                
                <label for="photo">Profile Photo</label>
                <input type="file" id="photo" name="photo" accept="image/*">
                
                <div class="form-buttons">
                    <button type="submit" class="save-btn">Save Changes</button>
                    <button type="button" onclick="showUserDetails()" class="cancel-btn">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function showEditForm() {
            document.getElementById('userDetails').style.display = 'none';
            document.getElementById('editForm').style.display = 'block';
        }
        
        function showUserDetails() {
            document.getElementById('editForm').style.display = 'none';
            document.getElementById('userDetails').style.display = 'block';
        }
        
        function confirmDelete() {
            if (confirm('Are you sure you want to delete your profile? This action cannot be undone and all your data will be permanently removed.')) {
                if (confirm('Final confirmation: Do you really want to delete your profile?')) {
                    window.location.href = 'delete_profile.php';
                }
            }
        }
        
        function confirmLogout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = 'logout.php';
            }
        }
    </script>
    <footer>
        &copy; <?php echo date('Y'); ?> Kapil Dev Bhandari. All rights reserved.
    </footer>
</body>
</html> 