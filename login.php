<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script>
        function login(event) {
            event.preventDefault();

            const user_id = document.getElementById('user_id').value;
            const section = document.getElementById('section').value;
            window.location.href = 'quiz.php?user_id=' + user_id + '&section=' + section;
        }
    </script>
</head>
<body>
    <form onsubmit="login(event);">
        <label for="user_id">User ID:</label>
        <input type="text" id="user_id" name="user_id" required><br>
        <label for="section">Section:</label>
        <select id="section" name="section" required>
            <option value="Listening">Listening</option>
            <option value="Flash">Flash</option>
        </select><br>
        <button type="submit">Start Quiz</button>
    </form>
</body>
</html>

