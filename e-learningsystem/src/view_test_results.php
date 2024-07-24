<?php
session_start();
require '../config/config.php';

// Check if the logged-in user is authorized (either user or mentor)
if ($_SESSION['role'] != 'user' && $_SESSION['role'] != 'mentor') {
    echo "You do not have permission to access this page.";
    exit();
}

// Validate input
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['test_id'])) {
    $test_id = $_GET['test_id'];
    $user_id = $_SESSION['user_id'];

    // Fetch mock test details including course name
    $sql_test = "SELECT m.*, c.name AS course_name, u.username AS mentor_name
                 FROM mock_tests m
                 INNER JOIN courses c ON m.course_id = c.id
                 INNER JOIN users u ON m.mentor_id = u.id
                 WHERE m.id = :test_id";
    $stmt_test = $main_conn->prepare($sql_test);
    $stmt_test->bindParam(':test_id', $test_id);
    $stmt_test->execute();
    $test = $stmt_test->fetch(PDO::FETCH_ASSOC);

    if (!$test) {
        echo "Invalid test ID or unauthorized access.";
        exit();
    }

    // Fetch test results for the logged-in user
    $sql_results = "SELECT u.username, tr.score, tr.feedback, tr.user_id
                    FROM test_results tr
                    INNER JOIN users u ON tr.user_id = u.id
                    WHERE tr.test_id = :test_id AND tr.user_id = :user_id";
    $stmt_results = $main_conn->prepare($sql_results);
    $stmt_results->bindParam(':test_id', $test_id);
    $stmt_results->bindParam(':user_id', $user_id);
    $stmt_results->execute();
    $results = $stmt_results->fetchAll(PDO::FETCH_ASSOC);

    // Fetch questions and user responses
    $sql_questions = "SELECT q.id, q.question, q.option_a, q.option_b, q.option_c, q.option_d, q.correct_option, ur.selected_option
                      FROM questions q
                      LEFT JOIN main_e_learning.user_responses ur ON q.id = ur.question_id AND ur.test_id = :test_id AND ur.user_id = :user_id
                      WHERE q.test_id = :test_id";
    $stmt_questions = $main_conn->prepare($sql_questions);
    $stmt_questions->bindParam(':test_id', $test_id);
    $stmt_questions->bindParam(':user_id', $user_id);
    $stmt_questions->execute();
    $questions = $stmt_questions->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Invalid request."; // This message shows if 'test_id' is not set properly in the URL
    exit();
}

include '../templates/header.php'; // Include header
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Test Results</title>
    <link rel="stylesheet" href="../styles/mentor.css"> <!-- Add your CSS file -->
</head>
<body>
    <div class="container">
        <h2>Test Results - Test ID: <?php echo htmlspecialchars($test_id); ?></h2>

        <h3>Test Details:</h3>
        <p>Course: <?php echo htmlspecialchars($test['course_name']); ?></p>
        <p>Date: <?php echo htmlspecialchars($test['date']); ?></p>
        <?php if ($_SESSION['role'] == 'mentor'): ?>
            <p>Mentor: <?php echo htmlspecialchars($test['mentor_name']); ?></p>
        <?php endif; ?>

        <h3>Results:</h3>
        <table>
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Score</th>
                    <th>Feedback</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($result['username']); ?></td>
                        <td><?php echo htmlspecialchars($result['score']); ?></td>
                        <td><?php echo htmlspecialchars($result['feedback']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Question-wise Performance:</h3>
        <table>
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Options</th>
                    <th>Correct Option</th>
                    <th>Selected Option</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($questions as $question): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($question['question']); ?></td>
                        <td>
                            <ul>
                                <li>A. <?php echo htmlspecialchars($question['option_a']); ?></li>
                                <li>B. <?php echo htmlspecialchars($question['option_b']); ?></li>
                                <li>C. <?php echo htmlspecialchars($question['option_c']); ?></li>
                                <li>D. <?php echo htmlspecialchars($question['option_d']); ?></li>
                            </ul>
                        </td>
                        <td><?php echo htmlspecialchars($question['correct_option']); ?></td>
                        <td><?php echo htmlspecialchars($question['selected_option'] ?? 'Not Answered'); ?></td>
                        <td>
                            <?php
                            if (!isset($question['selected_option'])) {
                                echo 'Not Answered';
                            } else {
                                echo $question['selected_option'] == $question['correct_option'] ? 'Correct' : 'Wrong';
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
