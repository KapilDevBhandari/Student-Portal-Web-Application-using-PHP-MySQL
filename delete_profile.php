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

if ($student) {
    try {
        $check_photo = $pdo->query("SHOW COLUMNS FROM students LIKE 'photo'");
        if ($check_photo->rowCount() > 0 && isset($student['photo']) && $student['photo']) {
            $photo_path = __DIR__ . '/uploads/' . $student['photo'];
            if (file_exists($photo_path)) {
                unlink($photo_path);
            }
        }
    } catch (PDOException $e) {
    }
    
    $delete_stmt = $pdo->prepare('DELETE FROM students WHERE id = ?');
    $delete_stmt->execute([$student_id]);
}

session_unset();
session_destroy();
header('Refresh: 2; URL=index.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="2;url=index.php">
    <title>Profile Deleted</title>
    <link rel="stylesheet" href="css/delete.css">
</head>
<body>
    <div class="container">
        <div class="delete-icon">🗑️</div>
        <h2>Profile Deleted Successfully</h2>
        <p>Your account has been permanently removed from our system.</p>
        <p>You will be redirected to the home page shortly.</p>
    </div>
</body>
</html> 