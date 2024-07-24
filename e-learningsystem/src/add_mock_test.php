<?php
session_start();
require '../config/config.php';

// Check if the logged-in user is a mentor
if ($_SESSION['role'] != 'mentor') {
    echo "You do not have permission to access this page.";
    exit();
}

// Fetch mentor ID from session
$mentor_id = $_SESSION['user_id'];

// Validate form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'];
    $date = $_POST['date']; // Ensure this is properly formatted for your database

    // Insert the mock test into the database
    $sql = "INSERT INTO mock_tests (course_id, mentor_id, date) VALUES (:course_id, :mentor_id, :date)";
    $stmt = $main_conn->prepare($sql);
    $stmt->bindParam(':course_id', $course_id);
    $stmt->bindParam(':mentor_id', $mentor_id);
    $stmt->bindParam(':date', $date);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Mock test added successfully.";
    } else {
        echo "Error adding mock test.";
    }
} else {
    echo "Invalid request.";
}
?>
