<?php
session_start();
require '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mentor_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $duration = $_POST['duration'];
    $degree = $_POST['degree'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    try {
        $sql = "INSERT INTO courses (name, duration, degree, category, description, mentor_id) 
                VALUES (:name, :duration, :degree, :category, :description, :mentor_id)";
        $stmt = $main_conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':duration', $duration);
        $stmt->bindParam(':degree', $degree);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':mentor_id', $mentor_id);
        $stmt->execute();

        echo "Course added successfully.";
    } catch (PDOException $e) {
        echo "Error adding course: " . $e->getMessage();
        // Optionally log the error message to a file
        error_log($e->getMessage(), 3, '../logs/errors.log');
    }

    // Delay to ensure the message is displayed before redirect
    header("refresh:10;url=../public/mentor.php");
    exit();
}
