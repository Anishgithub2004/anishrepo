<?php
session_start();
require '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $course_id = $_POST['course_id'];

    try {
        $sql = "INSERT INTO user_courses (user_id, course_id) VALUES (:user_id, :course_id)";
        $stmt = $main_conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':course_id', $course_id);
        $stmt->execute();

        echo "Course registered successfully.";
    } catch (PDOException $e) {
        echo "Error registering course: " . $e->getMessage();
        error_log("Error registering course: " . $e->getMessage(), 3, '../logs/errors.log');
    }

    header("refresh:2;url=../public/view_courses.php");
    exit();
}
?>
