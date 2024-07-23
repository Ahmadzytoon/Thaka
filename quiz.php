<?php
session_start();
include 'db.php';

if (!isset($_GET['user_id']) || !isset($_GET['section'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_GET['user_id'];
$section = $_GET['section'];

$sql = "SELECT * FROM questions WHERE section = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $section);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz</title>
</head>
<body>
    <h1>Quiz - <?php echo htmlspecialchars($section); ?></h1>
    <form method="post" action="submit_answers.php">
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div>
                <label><?php echo htmlspecialchars($row['question']); ?></label>
                <input type="hidden" name="question_id[]" value="<?php echo $row['id']; ?>">
                <input type="text" name="answer[]" required><br>
            </div>
        <?php } ?>
        <button type="submit">Submit Answers</button>
    </form>
</body>
</html>
<?php
$stmt->close();
?>

