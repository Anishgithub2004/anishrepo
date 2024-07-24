<?php
session_start();
require '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mentor_id = $_SESSION['user_id'];
    $course_id = $_POST['course_id'];
    $name = $_POST['name'];
    $duration = $_POST['duration'];
    $degree = $_POST['degree'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    try {
        $sql = "UPDATE courses SET name = :name, duration = :duration, degree = :degree, 
                category = :category, description = :description 
                WHERE id = :course_id AND mentor_id = :mentor_id";
        $stmt = $main_conn->prepare($sql);
        $stmt->bindParam(':course_id', $course_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':duration', $duration);
        $stmt->bindParam(':degree', $degree);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':mentor_id', $mentor_id);
        $stmt->execute();

        echo "Course updated successfully.";
    } catch (PDOException $e) {
        echo "Error updating course: " . $e->getMessage();
    }

    header("Location: ../public/mentor.php");
    exit();
}
?>
