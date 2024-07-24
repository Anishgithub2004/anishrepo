<?php
// Check if a session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../config/config.php';

$user_id = $_SESSION['user_id'];

// Fetch user's enrolled courses with mentor details
$sql_courses = "SELECT c.*, u.first_name as mentor_first_name, u.last_name as mentor_last_name 
                FROM user_courses uc 
                JOIN courses c ON uc.course_id = c.id 
                JOIN users u ON c.mentor_id = u.id 
                WHERE uc.user_id = :user_id";
$stmt_courses = $main_conn->prepare($sql_courses);
$stmt_courses->bindParam(':user_id', $user_id);
$stmt_courses->execute();
$courses = $stmt_courses->fetchAll(PDO::FETCH_ASSOC);

// Fetch mock tests for user's courses
$course_ids = array_column($courses, 'id');
$tests = [];
if (!empty($course_ids)) {
    $placeholders = implode(',', array_fill(0, count($course_ids), '?'));
    $sql_tests = "SELECT m.*, c.name AS course_name 
                  FROM mock_tests m
                  INNER JOIN courses c ON m.course_id = c.id
                  WHERE m.course_id IN ($placeholders)";
    $stmt_tests = $main_conn->prepare($sql_tests);
    foreach ($course_ids as $k => $course_id) {
        $stmt_tests->bindValue(($k+1), $course_id);
    }
    $stmt_tests->execute();
    $tests = $stmt_tests->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses</title>
    <link rel="stylesheet" href="../styles/my_courses.css"> <!-- Add your CSS file -->
</head>
<body>
    
    <div class="container">
        <h2>My Courses</h2>
        <div class="courses">
            <?php foreach ($courses as $course): ?>
                <div class="course">
                    <h3><?php echo htmlspecialchars($course['name']); ?></h3>
                    <p><?php echo htmlspecialchars($course['description']); ?></p>
                    <p>Mentor: <?php echo htmlspecialchars($course['mentor_first_name'] . ' ' . $course['mentor_last_name']); ?></p>
                    <a href="take_test.php?course_id=<?php echo $course['id']; ?>">Take Mock Test</a>
                    <form action="../src/delete_course.php" method="post">
                        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <button type="submit">Delete Course</button>
                    </form>
                    <!-- Display mock tests for the course -->
                    <h4>Mock Tests</h4>
                    <ul>
                        <?php foreach ($tests as $test): ?>
                            <?php if ($test['course_id'] == $course['id']): ?>
                                <li>
                                    <p>Test Date: <?php echo htmlspecialchars($test['date']); ?></p>
                                    <a href="../src/view_test_results.php?test_id=<?php echo htmlspecialchars($test['id']); ?>">View Test Results</a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include '../templates/footer.php'; // Include footer ?>
</body>
</html>
