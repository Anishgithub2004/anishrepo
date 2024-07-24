<?php
session_start();
require '../config/config.php';

if (!isset($_GET['course_id'])) {
    echo "No course selected.";
    exit();
}

$course_id = $_GET['course_id'];

$sql = "SELECT * FROM mock_tests WHERE course_id = :course_id ORDER BY date DESC LIMIT 1";
$stmt = $main_conn->prepare($sql);
$stmt->bindParam(':course_id', $course_id);
$stmt->execute();
$test = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$test) {
    echo "No mock test available for this course.";
    exit();
}

$test_id = $test['id'];

$sql = "SELECT * FROM questions WHERE test_id = :test_id";
$stmt = $main_conn->prepare($sql);
$stmt->bindParam(':test_id', $test_id);
$stmt->execute();
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../templates/header.php'; // Include header
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Mock Test</title>
    <link rel="stylesheet" href="../styles/take_test.css"> <!-- Add your CSS file -->
</head>
<body>
    <div class="container">
        <h2>Mock Test for <?php echo htmlspecialchars($course_id); ?></h2>
        <form action="../src/submit_test.php" method="post">
            <input type="hidden" name="test_id" value="<?php echo $test_id; ?>">
            <?php foreach ($questions as $question): ?>
                <div class="question">
                    <p><?php echo htmlspecialchars($question['question']); ?></p>
                    <input type="radio" name="answers[<?php echo $question['id']; ?>]" value="A"> <?php echo htmlspecialchars($question['option_a']); ?><br>
                    <input type="radio" name="answers[<?php echo $question['id']; ?>]" value="B"> <?php echo htmlspecialchars($question['option_b']); ?><br>
                    <input type="radio" name="answers[<?php echo $question['id']; ?>]" value="C"> <?php echo htmlspecialchars($question['option_c']); ?><br>
                    <input type="radio" name="answers[<?php echo $question['id']; ?>]" value="D"> <?php echo htmlspecialchars($question['option_d']); ?><br>
                </div>
            <?php endforeach; ?>
            <button type="submit">Submit Test</button>
        </form>
    </div>

    <?php include '../templates/footer.php'; // Include footer ?>
</body>
</html>
