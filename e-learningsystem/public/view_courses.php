<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../config/config.php';

$sql = "SELECT * FROM courses";
$stmt = $main_conn->prepare($sql);
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Courses</title>
    <link rel="stylesheet" href="../styles/view_courses.css"> <!-- Add your CSS file -->
</head>
<body>
    <?php include '../templates/view_courses.php'; ?> <!-- Include the view_courses.php template -->
    
    <?php include '../templates/footer.php'; // Include footer ?>
</body>
</html>
