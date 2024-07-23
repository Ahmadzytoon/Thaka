<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Function to start or stop the quiz
function toggleQuiz($action) {
    global $conn;
    $stmt = $conn->prepare("UPDATE quiz_status SET status = ?");
    $stmt->bind_param("s", $action);
    $stmt->execute();
    $stmt->close();
}

// Check if form is submitted for starting or stopping quiz
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['start_quiz'])) {
        toggleQuiz('active');
    } elseif (isset($_POST['stop_quiz'])) {
        toggleQuiz('inactive');
    }
}

// Function to add a new question
function addQuestion($question, $correct_answer, $section) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO questions (question, correct_answer, section) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $question, $correct_answer, $section);
    $stmt->execute();
    $stmt->close();
}

// Check if form is submitted for adding a new question
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_question'])) {
    $question = $_POST['question'];
    $correct_answer = $_POST['correct_answer'];
    $section = $_POST['section'];
    addQuestion($question, $correct_answer, $section);
}

// Fetch quiz status
$sql = "SELECT * FROM quiz_status";
$result = $conn->query($sql);
$quiz_status = "No quiz status available.";
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $quiz_status = "Quiz Status: " . $row["status"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Section Management</title>
</head>
<body>
    <h1>Section Management</h1>

    <!-- Start/Stop Quiz Buttons -->
    <form method="post" action="">
        <button type="submit" name="start_quiz">Start Quiz</button>
        <button type="submit" name="stop_quiz">Stop Quiz</button>
    </form>

    <!-- Add New Question Form -->
    <h2>Add New Question</h2>
    <form method="post" action="">
        <label for="question">Question:</label><br>
        <input type="text" id="question" name="question" required><br>
        <label for="correct_answer">Correct Answer:</label><br>
        <input type="text" id="correct_answer" name="correct_answer" required><br>
        <label for="section">Section:</label><br>
        <select id="section" name="section" required>
            <option value="Listening">Listening</option>
            <option value="Flash">Flash</option>
        </select><br>
        <button type="submit" name="add_question">Add Question</button>
    </form>

    <!-- Display Quiz Results -->
    <h2>Quiz Results</h2>
    <?php echo $quiz_status; ?>

</body>
</html>
