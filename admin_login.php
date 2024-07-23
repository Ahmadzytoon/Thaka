<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_username = $_POST['admin_username'];
    $admin_password = $_POST['admin_password'];

    // Fetch admin data from the database
    $stmt = $conn->prepare("SELECT password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $admin_username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($hash_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && $admin_password == $hash_password) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php");
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
</head>
<body>
    <h1>Admin Login</h1>
    <form method="post" action="admin_login.php">
        <label for="admin_username">Username:</label>
        <input type="text" id="admin_username" name="admin_username" required><br>
        <label for="admin_password">Password:</label>
        <input type="password" id="admin_password" name="admin_password" required><br>
        <button type="submit">Login</button>
    </form>
    <?php if (isset($error_message)) { echo "<p style='color: red;'>$error_message</p>"; } ?>
</body>
</html>
