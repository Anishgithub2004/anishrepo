<?php
session_start();
require '../config/config.php';

// Check if the logged-in user is a mentor
if ($_SESSION['role'] != 'mentor') {
    echo "You do not have permission to access this page.";
    exit();
}

// Validate form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $test_id = $_POST['test_id'];
    $question = $_POST['question'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $correct_option = $_POST['correct_option'];

    // Prepare and execute SQL statement to insert question into database
    $sql = "INSERT INTO questions (test_id, question, option_a, option_b, option_c, option_d, correct_option) 
            VALUES (:test_id, :question, :option_a, :option_b, :option_c, :option_d, :correct_option)";
    $stmt = $main_conn->prepare($sql);
    $stmt->bindParam(':test_id', $test_id);
    $stmt->bindParam(':question', $question);
    $stmt->bindParam(':option_a', $option_a);
    $stmt->bindParam(':option_b', $option_b);
    $stmt->bindParam(':option_c', $option_c);
    $stmt->bindParam(':option_d', $option_d);
    $stmt->bindParam(':correct_option', $correct_option);

    if ($stmt->execute()) {
        // Redirect back to the mentor dashboard or display a success message
        header("Location: ../public/mentor.php");
        exit();
    } else {
        echo "Error: Unable to add question.";
    }
} else {
    // Handle cases where the request method is not POST
    echo "Invalid request method.";
}
?>
