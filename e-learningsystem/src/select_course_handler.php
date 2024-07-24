<?php
session_start();
require '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id']; // Retrieve user ID from session
    $course_id = $_POST['course_id'];

    try {
        // Insert selected course into user_courses table
        $sql = "INSERT INTO user_courses (user_id, course_id) VALUES (:user_id, :course_id)";
        $stmt = $main_conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':course_id', $course_id);
        $stmt->execute();

        echo "Course selected successfully.";
    } catch(PDOException $e) {
        echo "Course selection failed: " . $e->getMessage();
    }

    // Redirect to some page after selection
    header("Location: ../public/my_courses.php");
    exit();
}
?>
