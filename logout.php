<?php
session_start();
session_unset();
session_destroy();
header('Refresh: 1; URL=index.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="1;url=index.php">
    <title>Logging Out...</title>
    <link rel="stylesheet" href="css/logout.css">
</head>
<body>
    <div class="container">
        <div class="logout-icon">👋</div>
        <h2>Logging you out...</h2>
        <p>You will be redirected shortly.</p>
    </div>
</body>
</html> 