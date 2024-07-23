<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <script>
        function goToSection(section) {
            window.location.href = 'section.php?section=' + section;
        }
    </script>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <button onclick="goToSection('Listening')">Manage Listening Section</button>
    <button onclick="goToSection('Flash')">Manage Flash Section</button>
    <button onclick="window.location.href='add_user.php'">Add Users</button>
</body>
</html>
