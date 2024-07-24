<?php
// Check if a session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../config/config.php';

if (isset($_POST['course_id']) && isset($_POST['user_id'])) {
    $course_id = $_POST['course_id'];
    $user_id = $_POST['user_id'];

    // Delete the course from user_courses
    $sql = "DELETE FROM user_courses WHERE user_id = :user_id AND course_id = :course_id";
    $stmt = $main_conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':course_id', $course_id);

    if ($stmt->execute()) {
        header("Location: ../public/my_courses.php");
        exit();
    } else {
        echo "Error deleting course.";
    }
} else {
    echo "Invalid request.";
}
?>
