<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $question_ids = $_POST['question_id'];
    $answers = $_POST['answer'];

    $score = 0;
    foreach ($question_ids as $index => $question_id) {
        $answer = $answers[$index];

        $stmt = $conn->prepare("SELECT correct_answer FROM questions WHERE id = ?");
        $stmt->bind_param("i", $question_id);
        $stmt->execute();
        $stmt->bind_result($correct_answer);
        $stmt->fetch();
        
        if ($correct_answer == $answer) {
            $score++;
        }
        $stmt->close();
    }

    echo "Your score is: $score";
}
?>
