<?php
session_start();
require '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id']; // Retrieve user ID from session
    $test_id = $_POST['test_id'];
    $score = $_POST['score']; // Assume score is calculated client-side and sent via POST
    $feedback = $_POST['feedback'];

    try {
        // Insert test result into test_results table
        $sql = "INSERT INTO test_results (user_id, test_id, score, feedback) VALUES (:user_id, :test_id, :score, :feedback)";
        $stmt = $main_conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':test_id', $test_id);
        $stmt->bindParam(':score', $score);
        $stmt->bindParam(':feedback', $feedback);
        $stmt->execute();

        echo "Test submitted successfully.";
    } catch(PDOException $e) {
        echo "Test submission failed: " . $e->getMessage();
    }

    // Redirect to some page after submission
    header("Location: ../public/test_results.php");
    exit();
}
?>
