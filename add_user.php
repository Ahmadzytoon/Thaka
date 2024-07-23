<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

function generateUserID() {
    return uniqid('user_');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $user_id = generateUserID();

    $sql = "INSERT INTO users (user_id, name) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user_id, $name);
    if ($stmt->execute()) {
        echo "User added successfully! User ID: " . $user_id;
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add User</title>
    <script>
        function addUser(event) {
            event.preventDefault();

            const name = document.getElementById('name').value;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'add_user.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    document.getElementById('userForm').reset();
                }
            };

            const data = `name=${encodeURIComponent(name)}`;
            xhr.send(data);
        }
    </script>
</head>
<body>
    <h1>Add User</h1>
    <form id="userForm" onsubmit="addUser(event);">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>
        <button type="submit">Add User</button>
    </form>
</body>
</html>
