<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit;
}
require_once 'config.php';
$student_id = $_SESSION['student_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $course = trim($_POST['course'] ?? '');
    $photo_name = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $photo_name = 'student_' . $student_id . '_' . time() . '.' . $ext;
        $target = __DIR__ . '/uploads/' . $photo_name;
        move_uploaded_file($_FILES['photo']['tmp_name'], $target);
    }
    try {
        $check_photo = $pdo->query("SHOW COLUMNS FROM students LIKE 'photo'");
        $photo_column_exists = $check_photo->rowCount() > 0;
    } catch (PDOException $e) {
        $photo_column_exists = false;
    }
    
    if ($photo_column_exists && $photo_name) {
        $sql = 'UPDATE students SET full_name = ?, phone = ?, course = ?, photo = ? WHERE id = ?';
        $params = [$full_name, $phone, $course, $photo_name, $student_id];
    } else {
        $sql = 'UPDATE students SET full_name = ?, phone = ?, course = ? WHERE id = ?';
        $params = [$full_name, $phone, $course, $student_id];
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
}
header('Refresh: 1; URL=dashboard.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="1;url=dashboard.php">
    <title>Updating Profile...</title>
    <link rel="stylesheet" href="css/update.css">
</head>
<body>
    <div class="container">
        <h2>Updating your profile...</h2>
        <div class="loading-spinner"></div>
        <p>You will be redirected shortly.</p>
    </div>
</body>
</html> 